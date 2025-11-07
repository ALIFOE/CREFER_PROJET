<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query();
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Media::getCategories();
        
        return view('admin.media.index', compact('media', 'categories'));
    }

    public function create()
    {
        $categories = Media::getCategories();
        return view('admin.media.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'media_file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,webm,ogg|max:10240',
            'is_featured' => 'boolean'
        ]);

        $file = $request->file('media_file');
        $extension = $file->getClientOriginalExtension();
        $type = in_array($extension, ['mp4', 'webm', 'ogg']) ? 'video' : 'image';
        
        // Générer un nom de fichier unique
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $category = $request->category;
        
        // Stocker le fichier original
        $path = $file->storeAs("media/{$category}", $fileName, 'public');
        $dimensions = null;

        if ($type === 'image') {
            // Charger l'image avec Intervention Image
            $image = Image::make($file);
            $originalWidth = $image->width();
            $originalHeight = $image->height();
            
            // Créer des versions redimensionnées
            $sizes = [
                'thumb' => [150, 150],
                'medium' => [800, null],
                'large' => [1200, null]
            ];
            
            $dimensions = [
                'original' => [
                    'width' => $originalWidth,
                    'height' => $originalHeight
                ]
            ];
            
            foreach ($sizes as $size => [$width, $height]) {
                $resized = Image::make($file);
                
                if ($height === null) {
                    // Redimensionner proportionnellement en largeur
                    $resized->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                } else {
                    // Recadrer et redimensionner
                    $resized->fit($width, $height);
                }
                
                $sizePath = "media/{$category}/{$size}_{$fileName}";
                Storage::disk('public')->put($sizePath, $resized->encode());
                
                $dimensions[$size] = [
                    'width' => $resized->width(),
                    'height' => $resized->height(),
                    'path' => $sizePath
                ];
            }
        }

        Media::create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $path,
            'type' => $type,
            'category' => $category,
            'dimensions' => $dimensions,
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Le média a été ajouté avec succès.');
    }

    public function destroy(Media $media)
    {
        // Supprimer le fichier physique
        if (Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Le média a été supprimé avec succès.');
    }
}