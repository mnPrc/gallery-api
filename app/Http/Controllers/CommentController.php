<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request) 
    {
        $data = $request->validated();


        $newCom = Comment::create($data);
        return response()->json($newCom);

        return Comment::addComment($request);
    }

    public function destroy($comment) 
    {
        return Comment::destroy($comment);
    }
}
