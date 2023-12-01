<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
   public function index()
   {
          $query = Gallery::with('comments', 'user', 'images');
          $galleries = $query->orderBy('id', 'desc')->paginate(10);

          return response()->json($galleries);
   }

   public function show($id)
   {
          $gallery = Gallery::with(['images', 'user', 'comments', 'comments.user'])->find($id);

          return response()->json($gallery);        
   }

   public function store(CreateGalleryRequest $request)
   {
          $validated = $request->validated();

          $gallery = Gallery::create([
               'user_id' => Auth::id(),
               'name' => $validated['name'],
               'description' => $validated['description']
          ]);

          $images = $request->get('images', []);

          foreach($images as $image){
               Image::create([
                    'gallery_id' => $gallery->id,
                    'imageUrl' => $image['imageUrl']
               ]);
          }

          $gallery->load('images','user', 'comments', 'comments.user');
          
          return response()->json($gallery);
   }

   public function update($id, UpdateGalleryRequest $request)
   {
          $validated = $request->validated();

          $gallery = Gallery::findOrFail($id);
          $gallery->update($validated);

          $images = $request->get('images', []);
          
          foreach ($images as $image) {
               $imagesArr[] = Image::create([
                    'gallery_id' => $gallery->id,
                    'imageUrl' => $image['imageUrl']
               ]);
          }

          $gallery->load('images','user', 'comments', 'comments.user');
          
          return response()->json($gallery);
   }

   public function destroy($id)
   {      
          $gallery = Gallery::findOrFail($id);
          $gallery->delete();
          return response()->noContent();
   }

   public function getMyProfile()
    {
        $activeUser = Auth::user();
        return response()->json($activeUser);
    }
}
