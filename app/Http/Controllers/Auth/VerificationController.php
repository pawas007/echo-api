<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->email_verified_at) {
            return response()->json(['message' => 'User already verified'], 201);
        }
        $token = Hash::make(Str::random(10));
        DB::table('users_email_verify')->where('user_id', $user->id)->delete();
        DB::table('users_email_verify')->insert([
            'user_id' => $user->id,
            'token' => $token
        ]);
        $user->sendVerificationEmail($token);
        return response()->json(['message' => 'Verify email send. Check your email']);

    }

    public function verifyEmail(Request $request)
    {
        try {

            $user = User::where('email', $request->email)
                ->first();
            if (!$user) {
                return response()->json(['message' => 'Invalid data try again'], 404);
            }
            if ($user->email_verified_at) {
                return response()->json(['message' => 'Already verified'], 200);
            }
            DB::beginTransaction();
            DB::table('users_email_verify')->where('user_id', $user->id)->delete();
            $user->email_verified_at = now();
            $user->save();
            DB::commit();
            return response()->json([], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }
}
