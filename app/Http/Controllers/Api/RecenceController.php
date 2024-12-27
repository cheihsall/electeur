<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RecenceController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|unique:users",
            "birth_date" => "required|date",
            "id_card_number" => "nullable|string|max:50",
            "phone" => "required|string|max:15|unique:users",
            "address" => "required|array",
            "role" => "required|in:Admin,Agent",
            "password" => "required|confirmed|min:4",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "birth_date" => $request->birth_date,
            "id_card_number" => $request->id_card_number,
            "phone" => $request->phone,
            "address" => json_encode($request->address),
            "role" => $request->role,
            "password" => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "user" => $user,
            "token" => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");
        
        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid login details",
            ], 401);
        }

        return response()->json([
            "status" => true,
            "message" => "User logged in successfully",
            "token" => $token,
            "user" => Auth::user()
        ]);
    }

    public function refreshToken()
    {
        return response()->json([
            "status" => true,
            "token" => Auth::refresh(),
            "message" => "Token refreshed successfully"
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }

    public function profile()
    {
        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => Auth::user()
        ]);
    }
}