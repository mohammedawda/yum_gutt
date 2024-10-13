<?php

namespace getways\settings\controllers;

use App\Http\Controllers\Controller;
use getways\settings\requests\SettingUpdateRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        return loadGetway('settings')->setting();
    }
    public function updateSetting(SettingUpdateRequest $request)
    {
        return loadGetway('settings')->updateSetting($request);
    }

}
