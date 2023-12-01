<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    
    public function store(Gallery $gallery , CreateCommentRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $comment = $gallery->comments()->create([
            'body' => $data['body'],
            'user_id' => $user->id,
        ]);

        return response()->json($comment);
    } 

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json($id,201);
    }
}
