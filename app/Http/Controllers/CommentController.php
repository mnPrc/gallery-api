<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
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
            'approved' => false,
        ]);
        
        return response()->json($comment);
    } 
    
    public function show(Request $request ,Gallery $gallery){
        
        $sortBy = $request->get('sort', 'created_at');
        $orderBy = $request->get('order', 'desc');
        
        $comments = $gallery->comments();

        switch($sortBy){
            case 'likes':
            $comments->withCount('likes')->orderBy('likes_count', $orderBy);
                break;
            case 'dislikes':
                $comments->withCount('dislikes')->orderBy('dislikes_count', $orderBy);
                break;
            case 'created_at':
                $comments->orderBy('created_at', $orderBy);
                break;
            default: 
                $comments->orderBy('created_at', $orderBy);
        }
        
        return response()->json($comments->get());
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
        $user = Auth::user();  
        if($user->is_admin || $comment->user_id === $user->id){
            $comment->delete();
            
            return response()->json(['message' => 'Comment Deleted']);
        }else{
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
