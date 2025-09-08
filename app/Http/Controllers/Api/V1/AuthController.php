<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send success response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request){
        // Validate input
        $validated =$request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Temp to authenticate User
        if (!Auth::attempt($validated)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // if success, create token sanctum
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Send success response
        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
