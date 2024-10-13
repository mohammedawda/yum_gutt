<?php

use App\Libraries\Setting;

if (!function_exists('getSettingByKey')) {
    function getSettingByKey(string $key)
    {
        $setting_obj = new Setting();
        return $setting_obj->getSettingByKey($key);
    }
}

if (!function_exists('getAllSettings')) {
    function getAllSettings()
    {
        $setting_obj = new Setting();
        return $setting_obj->getAllSettings();
    }
}