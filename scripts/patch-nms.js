/**
 * Postinstall patch for node-media-server: stop() crashes when connectCmdObj is
 * undefined (connection drops before RTMP "connect" completes).
 * @see https://github.com/illuspas/Node-Media-Server
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');
const target = path.join(
    root,
    'node_modules',
    'node-media-server',
    'src',
    'node_rtmp_session.js'
);

const OLD = `      Logger.log(\`[rtmp disconnect] id=\${this.id}\`);
      
      this.connectCmdObj.bytesWritten = this.socket.bytesWritten;
      this.connectCmdObj.bytesRead = this.socket.bytesRead;
      context.nodeEvent.emit('doneConnect', this.id, this.connectCmdObj);`;

const NEW = `      Logger.log(\`[rtmp disconnect] id=\${this.id}\`);
      if (this.connectCmdObj) {
        this.connectCmdObj.bytesWritten = this.socket.bytesWritten;
        this.connectCmdObj.bytesRead = this.socket.bytesRead;
        context.nodeEvent.emit('doneConnect', this.id, this.connectCmdObj);
      } else {
        context.nodeEvent.emit('doneConnect', this.id, {});
      }`;

function main() {
    if (!fs.existsSync(target)) {
        console.warn('[patch-nms] node-media-server not found, skip:', target);
        return;
    }

    let src = fs.readFileSync(target, 'utf8');
    if (src.includes('if (this.connectCmdObj)')) {
        console.log('[patch-nms] Already patched, skip.');
        return;
    }
    if (!src.includes(OLD)) {
        console.warn(
            '[patch-nms] Expected snippet not found; node-media-server may have changed. Skip patch.'
        );
        return;
    }
    src = src.replace(OLD, NEW);
    fs.writeFileSync(target, src, 'utf8');
    console.log('[patch-nms] Patched node_rtmp_session.js (connectCmdObj guard).');
}

main();
