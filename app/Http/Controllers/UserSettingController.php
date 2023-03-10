<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserSettingController extends Controller
{


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $user_id = Auth::user()->id;
        UserSetting::updateOrCreate(
            ['user_id' => Auth::user()->id,],
            ['notifications' => $request->settings['notifications']]
        );
       $settings =  UserSetting::where('user_id',$user_id)->first();
        return response()->json($settings);
    }
}
