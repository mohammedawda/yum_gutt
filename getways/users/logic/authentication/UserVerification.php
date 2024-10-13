<?php

namespace getways\users\logic\authentication;

use App\Mail\FullyVerifiedEmail;
use App\Mail\ProcessingDocumentEmail;
use Carbon\Carbon;
use Exception;
use getways\users\repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class UserVerification
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function verify($data)
    {
        try {
            $countryId = config('app.country_id');
            $user = $this->userRepository->get_user_dataByEmail($data['email'],$countryId);
            if ($user){
                if ($user->otp == $data['otp']) {
                    $user->update([
                        'email_verified_at' => Carbon::now(),
                    ]);
                    $email_data = [
                        'code' => $user->otp,
                        'name' => $user->name
                    ];
                    Mail::to($user->email)->queue(new ProcessingDocumentEmail($email_data));
                    Mail::to($user->email)->queue(new FullyVerifiedEmail($email_data));
                    if ($user->status) {
                        return sendResponse(true, __('Now you can make login and start a trading.'), []);
                    }
                    return response()->json([
                        'status'=>true,
                        'message'=>__('Your account has been created and is now ready for activation by the admin, please wait.'),
                        'user_id'=>$user->id
                    ]) ;
                }
            }

            return sendResponse(false, __('The code you entered is incorrect.'), []);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }

    }
    public function SendVerify($data)
    {
        try {

            $countryId = config('app.country_id');
            $user = $this->userRepository->get_user_dataByEmail($data['email'],$countryId);
            if ($user){
                $user->update([
                    'otp' => otp_generate(),
                ]);
                $email = new VerifyEmail([
                    'code' => $user->otp,
                    'name' => $user->name
                ]);
                Mail::to($user->email)->send($email);
                return sendResponse(true, __('The verification email has been dispatched.'), []);
            }
            return response()->json([
               'status'=>false,
               'message'=>__('Your data entered was wrong.')
            ]);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }

    }
}