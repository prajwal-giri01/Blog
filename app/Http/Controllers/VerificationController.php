<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(
                [
                    "stauts" => 400,
                    "message" => "Invalid/Expired url provided."
                ]);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json(
            [
                "stauts" => 200,
                "message" => "Email verified successfully"
            ]);
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(
                [
                    'status' => 400,
                    "message" => "Email already verified."
                ]);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => 200,
            "message" => "Email verification link sent on your email id"
        ]);
    }
}
