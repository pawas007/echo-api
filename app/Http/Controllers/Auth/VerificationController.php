<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsNotificator\SmsNotificatorInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function sendVerificationPhone(SmsNotificatorInterface $smsNotificator)
    {
        $user = Auth::user();
        if ($user->phone_verified_at) {
            return response()->json(['message' => 'Already verified']);
        }
        function randomNumber($length) {
            $result = '';
            for($i = 0; $i < $length; $i++) {
                $result .= mt_rand(0, 9);
            }
            return $result;
        }

        $code = randomNumber(4);
        $phoneVerifyTable = DB::table('users_phone_verify');
        $phoneVerifyTable->where('user_id', $user->id)->delete();

        try {
            DB::beginTransaction();
            $smsNotificator->sendVerifyCode($user->phone, $code);
            $phoneVerifyTable->insert(['code' =>  $code, 'user_id' => $user->id]);
            DB::commit();
            return response()->json(['message' => 'Message with code send']);
        } catch (Exception $exception) {
            DB::rollBack();
            if ((int) $exception->getCode() === 21211){
                return response()->json(['message'=>'Wrong phone number. Or try add country code without + symbol'], 500);
            }
             return response()->json(['message'=> $exception->getMessage()], 500);
        }
    }
}
