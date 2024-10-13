<?php

namespace getways\users\logic\authentication;

use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Exception;
use getways\users\repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResetPassword
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }
    public function reset(array $reset_data)
    {
        try {
            $email = $reset_data['email'];
            $countryId = config('app.country_id');
            $user = $this->userRepository->get_user_dataByEmail($email,$countryId);
            if (!$user) {
                return sendResponse(false, __('users.invalid_reset_data'), null, 401);
            }
            $latestSentOtp = Carbon::parse($user->latest_sent_otp);
            $currentTime = Carbon::now();

            if ($user->latest_sent_otp && $latestSentOtp->greaterThan($currentTime->subMinute())) {
                // The OTP was sent less than a minute ago
                return response()->json(['message' => __('OTP sent less than a minute ago')], 429); // 429 Too Many Requests
            } else {
                $otp =  otp_generate();
                $user->update([
                    'otp'=>$otp,
                    'latest_sent_otp'=>now(),
                ]);
                $email_data = [
                    'code' => $otp,
                    'name' => $user->name
                ];
                Mail::to($user->email)->queue(new VerifyEmail($email_data));
                return sendResponse(true, __('users.message_sent'), $user->email);
            }
        } catch(Exception $e) {
            Log::debug($e->getMessage().' ' .$e->getFile().'  ' .$e->getLine());
            return sendResponse(false, __('users.reset_exception'), null, null,500);
        }
    }
    public function change_password(array $data)
    {
        try {
            $email = $data['email'];
            $password = $data['password'];
            $otp = $data['otp'];
            $countryId = config('app.country_id');
            $user = $this->userRepository->get_user_dataByEmail($email,$countryId);
            if (!$user) {
                return sendResponse(false, __('users.invalid_reset_data'), null, 401);
            }
            if ($user->otp == $otp){
                $user->update([
                    'password'=>Hash::make($password),
                    'password_str' => $password,
                ]);
                return sendResponse(true, __('The password changed successfully.'), $user);
            }

            return sendResponse(false, __('OTP is wrong'), null, null,401);

        } catch(Exception $e) {
            Log::debug($e->getMessage().' ' .$e->getFile().'  ' .$e->getLine());
            return sendResponse(false, __('users.reset_exception'), null, null,500);
        }
    }

}
