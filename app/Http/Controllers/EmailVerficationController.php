<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerficationController extends Controller
{
    public function sendVerificationEmail(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return[
                'message' => "already verified"
            ];
        }
        $request->user()->sendEmailVerificationNotigication();

        return ['status' => 'verification-link-sent'];
    }
}
