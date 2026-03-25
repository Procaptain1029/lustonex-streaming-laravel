<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Video;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function photos(Request $request)
    {
        $query = Photo::with('user');

        $status = $request->get('status', 'pending');

        if ($status) {
            $query->where('status', $status);
        }

        // Filter by model name
        if ($request->filled('model')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->model . '%');
            });
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $photos = $query->latest()->paginate(20);

        return view('admin.content.photos', compact('photos', 'status'));
    }


    public function approvePhoto(Photo $photo)
    {
        $photo->update(['status' => 'approved']);

        ActivityLog::log('photo_approved', 'Foto aprobada: ' . $photo->title, $photo);

        return back()->with('success', __('admin.flash.content.photo_approved'));
    }

    public function rejectPhoto(Photo $photo)
    {
        $photo->update(['status' => 'rejected']);

        ActivityLog::log('photo_rejected', 'Foto rechazada: ' . $photo->title, $photo);

        return back()->with('success', __('admin.flash.content.photo_rejected'));
    }

    public function deletePhoto(Photo $photo)
    {
        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }
        if ($photo->thumbnail) {
            Storage::disk('public')->delete($photo->thumbnail);
        }

        $photo->delete();

        ActivityLog::log('photo_deleted_admin', 'Foto eliminada por admin: ' . $photo->title);

        return back()->with('success', __('admin.flash.content.photo_deleted'));
    }

    public function videos(Request $request)
    {
        $query = Video::with('user');

        $status = $request->filled('status') ? $request->status : 'pending';
        $query->where('status', $status);

        // Filter by model name
        if ($request->filled('model')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->model . '%');
            });
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $videos = $query->latest()->paginate(20);

        return view('admin.content.videos', compact('videos'));
    }


    public function approveVideo(Video $video)
    {
        $video->update(['status' => 'approved']);

        ActivityLog::log('video_approved', 'Video aprobado: ' . $video->title, $video);

        return back()->with('success', __('admin.flash.content.video_approved'));
    }

    public function rejectVideo(Video $video)
    {
        $video->update(['status' => 'rejected']);

        ActivityLog::log('video_rejected', 'Video rechazado: ' . $video->title, $video);

        return back()->with('success', __('admin.flash.content.video_rejected'));
    }

    public function deleteVideo(Video $video)
    {
        if ($video->path) {
            Storage::disk('public')->delete($video->path);
        }
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        ActivityLog::log('video_deleted_admin', 'Video eliminado por admin: ' . $video->title);

        return back()->with('success', __('admin.flash.content.video_deleted'));
    }
    public function massAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'selected' => 'required|array',
        ]);

        $action = $request->action;
        $ids = $request->selected;

        if ($action === 'approve') {
            \App\Models\Photo::whereIn('id', $ids)->update(['status' => 'approved']);
            $msg = __('admin.flash.content.photos_approved', ['count' => count($ids)]);
        } else {
            \App\Models\Photo::whereIn('id', $ids)->update(['status' => 'rejected']);
            $msg = __('admin.flash.content.photos_rejected', ['count' => count($ids)]);
        }

        return back()->with('success', $msg);
    }

}
