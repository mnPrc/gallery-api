<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;

class AdminController extends Controller
{

    public function listOfAllUsers()
    {
        $users = User::all();

        return response()->json($users);
    }
    
    public function manageAdminPrivileges($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->is_admin){
            //If user is already admin we can revoke
            $user->is_admin = false;
        }else{
            //If user isn't admin we can grant
            $user->is_admin = true;
        }

        $user->save();

        return response()->json(['message' => 'Successfully changed admin role']);
    }

    public function getAllUnapprovedComments()
    {
        $comments = Comment::with('user', 'gallery')->where('approved', false)->get();
        
        return response()->json($comments);
    }


    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = true;
        $comment->save();

        return response()->json(['message' => 'Comment approved successfully']);
    }
}
