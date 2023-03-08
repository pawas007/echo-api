<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VerificationController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendVerificationEmail(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->email_verified_at) {
            return response()->json(['message' => 'User already verified'], 201);
        }
        $user->sendVerificationEmail();
        return response()->json(['message' => 'Verify email send. Check your email']);

    }

    /**
     * @param Request $request
     * @return Exception|JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        try {

            $user = User::where('email', $request->email)
                ->first();
            if (!$user) {
                return response()->json(['message' => 'Invalid data try again'], 404);
            }
            if ($user->email_verified_at) {
                return response()->json(['message' => 'Already verified']);
            }
            DB::beginTransaction();
            DB::table('users_email_verify')->where('user_id', $user->id)->delete();
            $user->email_verified_at = now();
            $user->save();
            DB::commit();
            return response()->json(['message' => 'Verified'], 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }
}
