<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->photos()->latest();

        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility === 'public');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $photos = $query->paginate(20)->withQueryString();
        return view('model.photos.index', compact('photos'));
    }

    public function create()
    {
        return view('model.photos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'photos' => 'required|array|min:1|max:10',
            'photos.*' => 'required|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:10240',
            'is_public' => 'boolean',
        ], [
            'photos.max'      => __('admin.flash.photo.max_photos'),
            'photos.*.mimes'  => __('admin.flash.photo.invalid_mime'),
            'photos.*.max'    => __('admin.flash.photo.max_size'),
        ]);

        $uploadedPhotos = [];
        $user = auth()->user();

        foreach ($request->file('photos') as $index => $photoFile) {
            
            $filename = time() . '_' . $index . '_' . $photoFile->getClientOriginalName();
            $path = $photoFile->storeAs('photos', $filename, 'public');
            
            
            $thumbnail = null;
            try {
                $thumbnailPath = 'thumbnails/' . $filename;
                $fullPath = storage_path('app/public/' . $path);
                
                
                $thumbnailDir = storage_path('app/public/thumbnails');
                if (!file_exists($thumbnailDir)) {
                    mkdir($thumbnailDir, 0755, true);
                }
                
                
                if (class_exists('Intervention\Image\ImageManager')) {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($fullPath);
                    $image->cover(300, 300);
                    $image->save(storage_path('app/public/' . $thumbnailPath), 85);
                    $thumbnail = $thumbnailPath;
                } else {
                    
                    $this->createThumbnailWithGD($fullPath, storage_path('app/public/' . $thumbnailPath), 300, 300);
                    $thumbnail = $thumbnailPath;
                }
            } catch (\Exception $e) {
                
                \Log::warning('Error creando thumbnail: ' . $e->getMessage());
            }

            
            $photo = $user->photos()->create([
                'title' => $validated['title'] ? $validated['title'] . ' (' . ($index + 1) . ')' : null,
                'description' => $validated['description'] ?? null,
                'path' => $path,
                'thumbnail' => $thumbnail,
                'is_public' => $request->has('is_public'),
                'status' => 'pending',
                'file_size' => $photoFile->getSize(),
                'mime_type' => $photoFile->getMimeType(),
                'original_name' => $photoFile->getClientOriginalName(),
            ]);

            $uploadedPhotos[] = $photo;
        }

        
        $photoCount = count($uploadedPhotos);
        ActivityLog::log('photos_uploaded', "Subidas {$photoCount} fotos", $uploadedPhotos[0]);

        
        app(\App\Services\GamificationService::class)->checkAchievements($user);

        $message = $photoCount === 1
            ? __('admin.flash.photo.uploaded_one')
            : __('admin.flash.photo.uploaded_many', ['count' => $photoCount]);

        return redirect()->route('model.photos.index')->with('success', $message);
    }

    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        if ($photo->path) {
            Storage::disk('public')->delete($photo->path);
        }
        if ($photo->thumbnail) {
            Storage::disk('public')->delete($photo->thumbnail);
        }

        $photo->delete();

        ActivityLog::log('photo_deleted', 'Foto eliminada: ' . $photo->title);

        return redirect()->route('model.photos.index')->with('success', __('admin.flash.photo.deleted'));
    }

    
    private function createThumbnailWithGD($sourcePath, $destPath, $width, $height)
    {
        
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            throw new \Exception('No se pudo obtener información de la imagen');
        }

        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];

        
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                throw new \Exception('Formato de imagen no soportado: ' . $mimeType);
        }

        
        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = $width / $height;

        if ($sourceRatio > $targetRatio) {
            
            $newHeight = $height;
            $newWidth = $height * $sourceRatio;
        } else {
            
            $newWidth = $width;
            $newHeight = $width / $sourceRatio;
        }

        
        $destImage = imagecreatetruecolor($width, $height);
        
        
        if ($mimeType === 'image/png') {
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);
            $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
            imagefilledrectangle($destImage, 0, 0, $width, $height, $transparent);
        }

        
        $offsetX = ($width - $newWidth) / 2;
        $offsetY = ($height - $newHeight) / 2;

        
        imagecopyresampled(
            $destImage, $sourceImage,
            $offsetX, $offsetY, 0, 0,
            $newWidth, $newHeight, $sourceWidth, $sourceHeight
        );

        
        switch ($mimeType) {
            case 'image/png':
                imagepng($destImage, $destPath, 8);
                break;
            case 'image/gif':
                imagegif($destImage, $destPath);
                break;
            default:
                imagejpeg($destImage, $destPath, 85);
                break;
        }

        
        imagedestroy($sourceImage);
        imagedestroy($destImage);
    }
}
