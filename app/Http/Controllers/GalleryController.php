<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

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
}
