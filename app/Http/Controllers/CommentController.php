<?php

namespace App\Http\Controllers;

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
    
    public function show(Gallery $gallery){
        $comments = $gallery->comments;

        return response()->json($comments);
    }

    public function like($id){
        /** @var App\Models\User $user */
        $user = Auth::user();
        $comment = Comment::findOrFail($id);
        
        if($user->hasLikedComment($comment)){
            return response()->json(['error' => 'You have already liked this']);
        }

        if($user->hasDislikedComment($comment)){
            $comment->decrement('dislikes');
            $user->dislikedComments()->detach($comment);
        }

        if(!$user->hasLikedComment($comment)){
            $comment->increment('likes');
            $user->likedComments()->attach($comment);
        }
        
        return response()->json($comment);
        
    }

    public function dislike($id){
        /** @var App\Models\User $user */
        $user = Auth::user();
        $comment = Comment::findOrFail($id);

        if($user->hasDislikedComment($comment)){
            return response()->json(['error' => 'You have already disliked this.']);
        }

        if($user->hasLikedComment($comment)){
            $comment->decrement('likes');
            $user->likedComments()->detach($comment);
        }

        if(!$user->hasDislikedComment($comment)){
            $comment->increment('dislikes');
            $user->dislikedComments()->attach($comment);
        }

        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json($id,201);
    }
}
