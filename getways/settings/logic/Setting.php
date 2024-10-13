<?php

namespace getways\settings\logic;

use App\Mail\FullyVerifiedEmail;
use App\Mail\ProcessingDocumentEmail;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Exception;
use getways\settings\repositories\SettingRepository;
use getways\settings\resources\SettingResource;
use getways\users\repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Setting
{
    public function __construct(private readonly SettingRepository $settingRepository)
    {
    }
    public function setting()
    {
        try {
            $response_data =   SettingResource::collection($this->settingRepository->settings());
            return sendResponse(true, 'settings', $response_data);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }
    }
    public function updateSetting($request)
    {
        try {
            $response_data =   SettingResource::collection($this->settingRepository->updateSetting($request));
            return sendResponse(true, __('Update settings successfully.'), $response_data);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('setting_exception'), null, $em, 500);
        }
    }

}
