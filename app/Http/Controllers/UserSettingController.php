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
        UserSetting::updateOrCreate(
            ['user_id' => Auth::user()->id,],
            ['notifications' => $request->settings['notifications']]
        );
        return response()->json([]);
    }
}
