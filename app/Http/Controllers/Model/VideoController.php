<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $totalVideos = $user->videos()->count();

        $query = $user->videos()->latest();

        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility === 'public');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $videos = $query->paginate(20)->withQueryString();
        return view('model.videos.index', compact('videos', 'totalVideos'));
    }

    public function create()
    {
        return view('model.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:51200', // 50MB = 50 * 1024
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'is_public' => 'boolean',
        ], [
            'video.max'      => __('admin.flash.video.max_size'),
            'video.mimes'    => __('admin.flash.video.invalid_mime'),
            'thumbnail.max'  => __('admin.flash.video.thumb_max'),
        ]);

        $videoFile = $request->file('video');
        $filename = time() . '_' . $videoFile->getClientOriginalName();
        $path = $videoFile->storeAs('videos', $filename, 'public');

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
            $thumbnail = $thumbnailFile->storeAs('video-thumbnails', $thumbnailFilename, 'public');
        }

        $video = auth()->user()->videos()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'path' => $path,
            'thumbnail' => $thumbnail,
            'is_public' => $request->has('is_public'),
            'status' => 'pending',
            'duration' => 0, 
            'file_size' => $videoFile->getSize(),
            'mime_type' => $videoFile->getMimeType(),
            'original_name' => $videoFile->getClientOriginalName(),
        ]);

        ActivityLog::log('video_uploaded', 'Video subido: ' . $video->title, $video);

        return redirect()->route('model.videos.index')->with('success', __('admin.flash.video.uploaded'));
    }

    public function destroy(Video $video)
    {
        $this->authorize('delete', $video);

        if ($video->path) {
            Storage::disk('public')->delete($video->path);
        }
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        ActivityLog::log('video_deleted', 'Video eliminado: ' . $video->title);

        return redirect()->route('model.videos.index')->with('success', __('admin.flash.video.deleted'));
    }
}
