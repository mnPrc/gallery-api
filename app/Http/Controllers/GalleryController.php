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
     public function index(Request $request)
     {
          $term = $request->query('term', '');
          $user_id = $request->query('user_id', '');

          $galleries = Gallery::searchByTerm($term, $user_id)->orderBy('id','desc')->paginate(10);
          return response()->json($galleries);
     }

     public function show($id)
     {
          $gallery = Gallery::with([
               'images', 
               'user', 
               'comments' => function($query){
                    $query->where('approved', true)->with('user');
               }, 
               'comments.user', 
               'wishlists'
          ])->find($id);

          return response()->json($gallery);        
     }

     public function store(CreateGalleryRequest $request)
     {
          $validated = $request->validated();

          $gallery = Gallery::create([
               'user_id' => Auth::id(),
               'name' => $validated['name'],
               'description' => $validated['description'],
               'first_image_url' => isset($validated['images'][0]['imageUrl']) ? $validated['images'][0]['imageUrl'] : null,
               'price' => $validated['price'],
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
