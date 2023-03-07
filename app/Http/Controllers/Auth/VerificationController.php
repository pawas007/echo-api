<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {

        $authUser = User::where('email', $request->email)->first();
        if (!$authUser){
            return response()->json(['message' => 'User not found'],404);
        }
        if (!$authUser->email_verified_at){
            return response()->json(['message' => 'User already verified'],201);
        }
        $token = Hash::make(Str::random(10));
        DB::table('users_email_verify')->where('user_id', $authUser->id)->delete();
        DB::table('users_email_verify')->insert([
            'user_id' => $authUser->id,
            'token' => $token
        ]);

        $authUser->sendVerificationEmail($token);
        return response()->json(['message' => 'Verify email send. Check your email']);

    }


}
