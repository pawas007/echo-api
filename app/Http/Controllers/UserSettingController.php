<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Auth;

class UserSettingController extends Controller
{

    public function settings()
    {
        $setting =Auth::user()->settings();

        dd($setting);
        return $setting;
    }
    public function store()
    {
        $setting = new UserSetting();
        $setting->name = 'ostap';
        $setting->save();
   }
}
