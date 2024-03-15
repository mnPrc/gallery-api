<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepositMoneyRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    public function buyGallery(Request $request, $id)
    {
        $user = $request->user();
        $gallery = Gallery::findOrFail($id);
        
        if($user->money < $gallery->price) {
            return response()->json([
                'error' => 'Not enough money'
            ], 403);
        }
        
        $user->money -= $gallery->price;
        $user->save();
        
        $seller = $gallery->user;
        $seller->money += $gallery->price;
        $seller->save();

        $gallery->buyer_id = $user->id;
        $gallery->save();

        return response()->json(['message' => 'Succesfully puchased gallery']);
    }
    
    public function deposit(DepositMoneyRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $user->money += $validated['money'];
        $user->save();

        return response()->json(['message' => 'Successfully deposited money ']);
    }
}
