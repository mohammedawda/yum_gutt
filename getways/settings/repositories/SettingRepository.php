<?php

namespace getways\settings\repositories;

use getways\settings\models\Setting;
use getways\users\models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class SettingRepository
{
    public function settings()
    {
        return Setting::where('status', 1)->get();
    }
    public function updateSetting($request)
    {
        $settings =  $request->settings;
        foreach ($settings as $setting) {
            Setting::where('name', $setting['name'])->update(['value' => $setting['value']]);
        }
        return Setting::where('status', 1)->get();
    }

}
