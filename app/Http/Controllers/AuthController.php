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
            'role'=>'author',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user,

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
        $user->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ['user' => $user,
                'token' => $user->createToken('myapptoken')->plainTextToken],
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
