<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'max:250', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('author');
        $token = $user->createToken('myapptoken')->plainTextToken;
        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user,
            'token' => $token

        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if the user's email is verified
        if(!$user->hasVerifiedEmail()){
            return response()->json([
                'status' => 401,
                'message' => 'Email not verified',
            ], 401);
        }

        // Delete existing tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'user' => $user,
                'token' => $token
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('sanctum')->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout successfully',
        ]);
    }

}
