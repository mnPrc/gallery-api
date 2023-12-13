<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $token = Auth::login($user);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }

    public function getMyGalleries()
    {
        $activeUser = Auth::user();
        return response()->json($activeUser);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'token' => Auth::refresh(),    
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->noContent();
    }
}
