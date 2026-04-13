/**
 * Lustonex Streaming Server
 * RTMP Ingest + LL-HLS Transcoding via FFmpeg
 * 
 * Run: node rtmp-server.cjs  (or: npm run rtmp)
 * 
 * Architecture:
 *   OBS (RTMP) → Node-Media-Server (port 1935) → FFmpeg → LL-HLS segments (public/hls/)
 *   Viewers → Laravel serves HLS from public/hls/ → HLS.js player (2-4s latency)
 */

const NodeMediaServer = require('node-media-server');
const { spawn } = require('child_process');
const path = require('path');
const fs = require('fs');

// Load .env
try { require('dotenv').config(); } catch (e) { /* dotenv optional */ }

// Global error hooks (register before NMS; helps debug handshake / plugin issues)
process.on('uncaughtException', (err) => {
    console.error('[rtmp-server] uncaughtException:', err && err.stack ? err.stack : err);
});
process.on('unhandledRejection', (reason) => {
    console.error('[rtmp-server] unhandledRejection:', reason);
});

// ════════════════════════════════════════════
// Configuration
// ════════════════════════════════════════════

const LARAVEL_URL = process.env.APP_URL || 'http://127.0.0.1:8000';
/** Set RTMP_DEBUG=1 for Node-Media-Server DEBUG logs + extra TCP hints */
const RTMP_DEBUG = process.env.RTMP_DEBUG === '1' || process.env.RTMP_DEBUG === 'true';
const RTMP_PORT = parseInt(process.env.RTMP_PORT || '1935');
const HTTP_PORT = parseInt(process.env.RTMP_HTTP_PORT || '8080');
const HLS_ROOT = path.resolve(__dirname, 'public', 'hls');
const MULTI_QUALITY = process.env.RTMP_MULTI_QUALITY === 'true';

// LL-HLS settings
const HLS_TIME = parseInt(process.env.HLS_TIME || '1');           // Segment duration in seconds
const HLS_LIST_SIZE = parseInt(process.env.HLS_LIST_SIZE || '6'); // Segments in playlist
const KEYFRAME_SEC = parseInt(process.env.KEYFRAME_SEC || '1');   // Keyframe interval
const FPS = parseInt(process.env.STREAM_FPS || '30');
const GOP = FPS * KEYFRAME_SEC; // Frames per keyframe

// FFmpeg path
let ffmpegPath;
try {
    ffmpegPath = require('@ffmpeg-installer/ffmpeg').path;
} catch (e) {
    ffmpegPath = process.env.FFMPEG_PATH || 'ffmpeg';
}

// ════════════════════════════════════════════
// Ensure directories exist
// ════════════════════════════════════════════

const hlsLiveDir = path.join(HLS_ROOT, 'live');
[HLS_ROOT, hlsLiveDir].forEach(dir => {
    if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
    }
});

// Active FFmpeg processes
const ffmpegProcesses = new Map();

// ════════════════════════════════════════════
// HTTP fetch helper (works with node-fetch v2 CommonJS)
// ════════════════════════════════════════════

let fetchFn;
try {
    fetchFn = require('node-fetch');
} catch (e) {
    // Fallback to Node 18+ global fetch
    fetchFn = globalThis.fetch;
}

async function apiFetch(urlPath, body = {}) {
    try {
        const url = `${LARAVEL_URL}${urlPath}`;
        const res = await fetchFn(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });
        return res;
    } catch (err) {
        console.error(`[API] Error calling ${urlPath}:`, err.message);
        return null;
    }
}

// ════════════════════════════════════════════
// Node-Media-Server (RTMP Ingest)
// ════════════════════════════════════════════

// NMS Logger LOG_TYPES: NONE=0, ERROR=1, NORMAL=2, DEBUG=3, FFDEBUG=4
const NMS_LOG_NORMAL = 2;
const NMS_LOG_DEBUG = 3;

const nmsConfig = {
    logType: RTMP_DEBUG ? NMS_LOG_DEBUG : NMS_LOG_NORMAL,
    rtmp: {
        port: RTMP_PORT,
        chunk_size: 60000,
        gop_cache: true,
        ping: 30,
        ping_timeout: 120, // seconds (socket idle); generous for slow encoders
    },
    http: {
        port: HTTP_PORT,
        mediaroot: path.resolve(__dirname, 'public'),
        allow_origin: '*',
    },
};

const nms = new NodeMediaServer(nmsConfig);

// ════════════════════════════════════════════
// RTMP Event Handlers
// ════════════════════════════════════════════

nms.on('preConnect', (id, args) => {
    const app = args && args.app ? args.app : '?';
    const flashVer = args && args.flashVer ? String(args.flashVer).slice(0, 80) : '';
    console.log(`[RTMP] Client connecting: id=${id} app=${app}${flashVer ? ` flashVer=${flashVer}` : ''}`);
});

nms.on('postConnect', (id, args) => {
    const app = args && args.app ? args.app : '?';
    console.log(`[RTMP] Client connected (RTMP connect OK): id=${id} app=${app}`);
});

nms.on('doneConnect', (id, args) => {
    const early = !args || Object.keys(args).length === 0;
    const bytes = args && typeof args.bytesRead === 'number'
        ? ` read=${args.bytesRead} written=${args.bytesWritten || 0}`
        : '';
    console.log(
        `[RTMP] Client disconnected: id=${id}${early ? ' (before RTMP connect completed — check OBS “Enhanced RTMP/FLV” is OFF)' : ''}${bytes}`
    );
});

/**
 * prePublish: OBS starts streaming
 * - Authenticate stream key with Laravel
 * - Start FFmpeg LL-HLS transcoding
 */
nms.on('prePublish', async (id, StreamPath, args) => {
    console.log(`[RTMP] 📡 Publish started: ${StreamPath}`);

    const parts = StreamPath.split('/');
    const streamKey = parts[parts.length - 1];
    const app = parts[1] || 'live';

    if (app !== 'live') {
        console.log(`[RTMP] Ignoring non-live app: ${app}`);
        return;
    }

    // Authenticate with Laravel
    const authRes = await apiFetch('/api/rtmp/auth', { name: streamKey });

    if (authRes && authRes.status !== 200) {
        console.log(`[RTMP] ❌ Auth FAILED for key: ${streamKey} (status ${authRes.status})`);
        const session = nms.getSession(id);
        if (session) session.reject();
        return;
    }

    if (!authRes) {
        console.log(`[RTMP] ⚠️  Laravel unreachable, allowing stream in dev mode`);
    } else {
        console.log(`[RTMP] ✅ Auth OK for key: ${streamKey}`);
    }

    // Start LL-HLS transcoding
    startTranscoding(streamKey);
});

/**
 * donePublish: OBS stops streaming
 * - Kill FFmpeg process
 * - Notify Laravel
 * - Schedule HLS cleanup
 */
nms.on('donePublish', async (id, StreamPath, args) => {
    console.log(`[RTMP] 📴 Publish ended: ${StreamPath}`);

    const parts = StreamPath.split('/');
    const streamKey = parts[parts.length - 1];

    stopTranscoding(streamKey);

    // Notify Laravel
    await apiFetch('/api/rtmp/publish-done', { name: streamKey });

    // Cleanup HLS files after 30s (let viewers finish)
    setTimeout(() => cleanupHLS(streamKey), 30000);
});

nms.on('prePlay', async (id, StreamPath, args) => {
    const parts = StreamPath.split('/');
    const streamKey = parts[parts.length - 1];
    console.log(`[RTMP] 👁️  Viewer connected: ${streamKey}`);
    await apiFetch('/api/rtmp/play', { name: streamKey });
});

nms.on('donePlay', async (id, StreamPath, args) => {
    const parts = StreamPath.split('/');
    const streamKey = parts[parts.length - 1];
    console.log(`[RTMP] 👁️  Viewer left: ${streamKey}`);
    await apiFetch('/api/rtmp/play-done', { name: streamKey });
});

// ════════════════════════════════════════════
// FFmpeg LL-HLS Transcoding
// ════════════════════════════════════════════

/**
 * Start FFmpeg transcoding: RTMP → LL-HLS
 * 
 * LL-HLS config:
 *  - 1s segments (hls_time=1)
 *  - 6 segments in playlist
 *  - 1s keyframe interval (GOP = FPS)
 *  - delete_segments for disk management
 *  - program_date_time for sync
 *  - independent_segments for ABR switching
 */
function startTranscoding(streamKey) {
    if (ffmpegProcesses.has(streamKey)) {
        console.log(`[FFmpeg] Already transcoding: ${streamKey}`);
        return;
    }

    const streamDir = path.join(hlsLiveDir, streamKey);
    if (!fs.existsSync(streamDir)) {
        fs.mkdirSync(streamDir, { recursive: true });
    }

    const inputUrl = `rtmp://127.0.0.1:${RTMP_PORT}/live/${streamKey}`;

    let ffmpegArgs;

    if (MULTI_QUALITY) {
        ffmpegArgs = buildMultiQualityArgs(inputUrl, streamDir, streamKey);
    } else {
        ffmpegArgs = buildSingleQualityArgs(inputUrl, streamDir);
    }

    console.log(`[FFmpeg] 🚀 Starting transcoding for: ${streamKey}`);
    console.log(`[FFmpeg] Mode: ${MULTI_QUALITY ? 'Multi-quality (720p/480p/360p)' : 'Single quality (720p)'}`);

    const ffmpeg = spawn(ffmpegPath, ffmpegArgs, {
        stdio: ['ignore', 'pipe', 'pipe']
    });

    let lastLogTime = 0;

    ffmpeg.stderr.on('data', (data) => {
        const msg = data.toString();

        // Log errors always
        if (msg.toLowerCase().includes('error') && !msg.includes('concealing')) {
            console.error(`[FFmpeg:${streamKey}] ❌`, msg.trim().substring(0, 200));
        }

        // Log progress every 10 seconds
        const now = Date.now();
        if (msg.includes('frame=') && now - lastLogTime > 10000) {
            lastLogTime = now;
            const match = msg.match(/frame=\s*(\d+).*fps=\s*([\d.]+).*speed=\s*([\d.x]+)/);
            if (match) {
                console.log(`[FFmpeg:${streamKey}] 📊 frame=${match[1]} fps=${match[2]} speed=${match[3]}`);
            }
        }
    });

    ffmpeg.on('close', (code) => {
        console.log(`[FFmpeg:${streamKey}] Process exited (code ${code})`);
        ffmpegProcesses.delete(streamKey);
    });

    ffmpeg.on('error', (err) => {
        console.error(`[FFmpeg:${streamKey}] Spawn error:`, err.message);
        ffmpegProcesses.delete(streamKey);
    });

    ffmpegProcesses.set(streamKey, ffmpeg);
}

/**
 * Single quality: 720p LL-HLS
 */
function buildSingleQualityArgs(inputUrl, streamDir) {
    const segPattern = path.join(streamDir, 'seg_%05d.ts').replace(/\\/g, '/');
    const playlist = path.join(streamDir, 'index.m3u8').replace(/\\/g, '/');

    return [
        '-i', inputUrl,
        '-y',
        '-loglevel', 'warning',
        '-stats',

        // Video: re-encode with 1s keyframes for LL-HLS
        '-c:v', 'libx264',
        '-preset', 'ultrafast',
        '-tune', 'zerolatency',
        '-profile:v', 'main',
        '-b:v', '2500k',
        '-maxrate', '2500k',
        '-bufsize', '5000k',
        '-s', '1280x720',
        '-r', String(FPS),
        '-g', String(GOP),
        '-keyint_min', String(GOP),
        '-sc_threshold', '0',
        '-flags', '+cgop',

        // Audio
        '-c:a', 'aac',
        '-b:a', '128k',
        '-ac', '2',
        '-ar', '44100',

        // LL-HLS Output
        '-f', 'hls',
        '-hls_time', String(HLS_TIME),
        '-hls_list_size', String(HLS_LIST_SIZE),
        '-hls_flags', 'delete_segments+independent_segments+program_date_time',
        '-hls_segment_type', 'mpegts',
        '-hls_segment_filename', segPattern,

        playlist
    ];
}

/**
 * Multi quality: 720p + 480p + 360p LL-HLS with master playlist
 */
function buildMultiQualityArgs(inputUrl, streamDir, streamKey) {
    // Create quality subdirectories
    ['720p', '480p', '360p'].forEach(q => {
        const dir = path.join(streamDir, q);
        if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    });

    const seg720 = path.join(streamDir, '720p', 'seg_%05d.ts').replace(/\\/g, '/');
    const out720 = path.join(streamDir, '720p', 'index.m3u8').replace(/\\/g, '/');
    const seg480 = path.join(streamDir, '480p', 'seg_%05d.ts').replace(/\\/g, '/');
    const out480 = path.join(streamDir, '480p', 'index.m3u8').replace(/\\/g, '/');
    const seg360 = path.join(streamDir, '360p', 'seg_%05d.ts').replace(/\\/g, '/');
    const out360 = path.join(streamDir, '360p', 'index.m3u8').replace(/\\/g, '/');

    // Common encoding args
    const commonVideo = [
        '-preset', 'ultrafast',
        '-tune', 'zerolatency',
        '-profile:v', 'main',
        '-g', String(GOP),
        '-keyint_min', String(GOP),
        '-sc_threshold', '0',
        '-flags', '+cgop',
    ];

    const commonHLS = [
        '-hls_time', String(HLS_TIME),
        '-hls_list_size', String(HLS_LIST_SIZE),
        '-hls_flags', 'delete_segments+independent_segments+program_date_time',
        '-hls_segment_type', 'mpegts',
    ];

    const args = [
        '-i', inputUrl,
        '-y',
        '-loglevel', 'warning',
        '-stats',

        // ===== Output 1: 720p =====
        '-map', '0:v:0', '-map', '0:a:0',
        '-c:v', 'libx264', ...commonVideo,
        '-s', '1280x720', '-r', String(FPS),
        '-b:v', '2500k', '-maxrate', '2500k', '-bufsize', '5000k',
        '-c:a', 'aac', '-b:a', '128k', '-ac', '2', '-ar', '44100',
        '-f', 'hls', ...commonHLS,
        '-hls_segment_filename', seg720,
        out720,

        // ===== Output 2: 480p =====
        '-map', '0:v:0', '-map', '0:a:0',
        '-c:v', 'libx264', ...commonVideo,
        '-s', '854x480', '-r', String(FPS),
        '-b:v', '1000k', '-maxrate', '1000k', '-bufsize', '2000k',
        '-c:a', 'aac', '-b:a', '96k', '-ac', '2', '-ar', '44100',
        '-f', 'hls', ...commonHLS,
        '-hls_segment_filename', seg480,
        out480,

        // ===== Output 3: 360p =====
        '-map', '0:v:0', '-map', '0:a:0',
        '-c:v', 'libx264', ...commonVideo,
        '-s', '640x360', '-r', String(FPS),
        '-b:v', '500k', '-maxrate', '500k', '-bufsize', '1000k',
        '-c:a', 'aac', '-b:a', '64k', '-ac', '2', '-ar', '44100',
        '-f', 'hls', ...commonHLS,
        '-hls_segment_filename', seg360,
        out360,
    ];

    // Write master playlist
    writeMasterPlaylist(streamDir);

    return args;
}

/**
 * Generate ABR master playlist for multi-quality
 */
function writeMasterPlaylist(streamDir) {
    const master = `#EXTM3U
#EXT-X-VERSION:6
#EXT-X-INDEPENDENT-SEGMENTS

#EXT-X-STREAM-INF:BANDWIDTH=2628000,RESOLUTION=1280x720,CODECS="avc1.4d001f,mp4a.40.2",NAME="720p"
720p/index.m3u8

#EXT-X-STREAM-INF:BANDWIDTH=1096000,RESOLUTION=854x480,CODECS="avc1.4d001e,mp4a.40.2",NAME="480p"
480p/index.m3u8

#EXT-X-STREAM-INF:BANDWIDTH=564000,RESOLUTION=640x360,CODECS="avc1.4d0015,mp4a.40.2",NAME="360p"
360p/index.m3u8
`;
    fs.writeFileSync(path.join(streamDir, 'index.m3u8'), master);
}

function stopTranscoding(streamKey) {
    const proc = ffmpegProcesses.get(streamKey);
    if (!proc) return;

    console.log(`[FFmpeg] ⏹️  Stopping transcoding for: ${streamKey}`);

    // Graceful stop
    try { proc.stdin && proc.stdin.write('q'); } catch (e) { /* ignore */ }

    // Force kill after 5s
    setTimeout(() => {
        if (!proc.killed) {
            proc.kill('SIGKILL');
        }
    }, 5000);

    ffmpegProcesses.delete(streamKey);
}

function cleanupHLS(streamKey) {
    const dir = path.join(hlsLiveDir, streamKey);
    if (fs.existsSync(dir)) {
        fs.rmSync(dir, { recursive: true, force: true });
        console.log(`[HLS] 🧹 Cleaned up: ${streamKey}`);
    }
}

// ════════════════════════════════════════════
// Graceful Shutdown
// ════════════════════════════════════════════

function shutdown() {
    console.log('\n[Server] Shutting down...');

    // Stop all FFmpeg processes
    for (const [key, proc] of ffmpegProcesses) {
        console.log(`[FFmpeg] Stopping: ${key}`);
        proc.kill('SIGTERM');
    }
    ffmpegProcesses.clear();

    // Stop NMS
    nms.stop();

    process.exit(0);
}

process.on('SIGINT', shutdown);
process.on('SIGTERM', shutdown);

/**
 * Log raw TCP accepts on the RTMP port (helps when OBS connects but RTMP handshake fails).
 */
function attachRtmpTcpLogging(nmsInstance) {
    const nrs = nmsInstance && nmsInstance.nrs;
    const tcpServer = nrs && nrs.tcpServer;
    if (!tcpServer) {
        console.warn('[RTMP/TCP] Could not attach TCP logger (internal API changed).');
        return;
    }
    tcpServer.on('connection', (socket) => {
        const r = `${socket.remoteAddress || '?'}:${socket.remotePort || '?'}`;
        console.log(`[RTMP/TCP] socket accepted from ${r}`);
        let hintTimer;
        if (RTMP_DEBUG) {
            hintTimer = setTimeout(() => {
                console.log(
                    `[RTMP/TCP] ${r} still open after 3s — if you never see "[RTMP] Client connecting", handshake or protocol mismatch (OBS: disable Enhanced RTMP).`
                );
            }, 3000);
        }
        socket.on('close', (hadError) => {
            if (hintTimer) clearTimeout(hintTimer);
            console.log(`[RTMP/TCP] socket closed ${r}${hadError ? ' (hadError)' : ''}`);
        });
        socket.on('error', (err) => {
            if (hintTimer) clearTimeout(hintTimer);
            console.error(`[RTMP/TCP] socket error ${r}:`, err && err.message ? err.message : err);
        });
    });
}

function runStartupSelfTest() {
    console.log('[Startup] Laravel API base:', LARAVEL_URL, '(POST /api/rtmp/* must reach this URL)');
    if (fs.existsSync(ffmpegPath)) {
        console.log('[Startup] FFmpeg binary OK:', ffmpegPath);
    } else {
        console.warn('[Startup] WARNING: FFmpeg path not found:', ffmpegPath, '— install FFmpeg or set FFMPEG_PATH');
    }
    if (RTMP_DEBUG) {
        console.log('[Startup] RTMP_DEBUG=1 — Node-Media-Server DEBUG logging enabled.');
    }
    console.log(`
--- Quick test checklist ---
1) php artisan serve  (same host as APP_URL)
2) npm run rtmp
3) OBS: Custom server rtmp://127.0.0.1:${RTMP_PORT}/live  + stream key from dashboard
4) OBS Settings → Advanced → Network: disable "Enable Enhanced RTMP/FLV"
5) Output: x264 or NVENC, keyframe interval ${KEYFRAME_SEC}s, ~2500 kbps
----------------------------`);
}

// ════════════════════════════════════════════
// Start
// ════════════════════════════════════════════

nms.run();
attachRtmpTcpLogging(nms);
runStartupSelfTest();

console.log(`
╔══════════════════════════════════════════════════════╗
║           🎥  Lustonex Streaming Server              ║
╠══════════════════════════════════════════════════════╣
║                                                      ║
║  RTMP Ingest:  rtmp://127.0.0.1:${String(RTMP_PORT).padEnd(5)}/live        ║
║  HTTP Stats:   http://127.0.0.1:${String(HTTP_PORT).padEnd(5)}             ║
║  HLS Output:   public/hls/live/{stream_key}/         ║
║  FFmpeg:       ${ffmpegPath.substring(0, 38).padEnd(38)} ║
║                                                      ║
╠══════════════════════════════════════════════════════╣
║  LL-HLS Configuration:                               ║
║  ├─ Segment Duration:  ${String(HLS_TIME).padEnd(3)}s                       ║
║  ├─ Playlist Size:     ${String(HLS_LIST_SIZE).padEnd(3)}segments               ║
║  ├─ Keyframe Interval: ${String(KEYFRAME_SEC).padEnd(3)}s (GOP=${String(GOP).padEnd(3)})            ║
║  ├─ FPS:               ${String(FPS).padEnd(3)}                            ║
║  ├─ Multi-Quality:     ${String(MULTI_QUALITY ? 'ON (720/480/360p)' : 'OFF (720p only)').padEnd(27)} ║
║  └─ Target Latency:    2-4s                          ║
║                                                      ║
╠══════════════════════════════════════════════════════╣
║  OBS Studio Settings:                                ║
║  ├─ Server:   rtmp://127.0.0.1:${String(RTMP_PORT).padEnd(5)}/live         ║
║  ├─ Key:      (from platform dashboard)              ║
║  ├─ Encoder:  x264 / NVENC                           ║
║  ├─ Keyframe: ${String(KEYFRAME_SEC).padEnd(3)}s                               ║
║  ├─ Bitrate:  2500 kbps                              ║
║  ├─ Profile:  Main                                   ║
║  └─ Tune:     zerolatency                            ║
║                                                      ║
╚══════════════════════════════════════════════════════╝
`);
