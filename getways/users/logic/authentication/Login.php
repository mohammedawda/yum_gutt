<?php

namespace getways\users\logic\authentication;

use Exception;
use getways\users\models\User;
use getways\users\repositories\AuthRepository;
use getways\users\resources\AdminResource;
use getways\users\resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function __construct(private AuthRepository $userRepository)
    {
    }

    public function login(array $data)
    {
        $login_data = $data['login_data'];
        $request = $data['request'];
        try {
            $credentials = $this->prepareLoginCredentials($login_data);
            $loginType = key($credentials);

            $countryId = config('app.country_id');
            $user = \getways\users\models\User::where($loginType, $credentials[$loginType])->where('country_id',$countryId)->first();
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $data = $this->userLogin($user,$login_data,$countryId);
                if (!$data['status']){
                    return $data['message'];
                }
                $response_data = $data['response_data'];
                return sendResponse(true, trans('users.login_success'), $response_data);
            }
            return sendResponse(false, __('Invalid data.'), null);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null,$em, 500);
        }
    }
    public function admin_login(array $data)
    {
        try {
            $login_data = $data['login_data'];
            $request = $data['request'];
            $credentials = $this->prepareLoginCredentials($login_data);
            $loginType = key($credentials);
            $countryId = config('app.country_id');
            $admin = \getways\users\models\User::where('role_id', User::ADMIN_ROLE)->where($loginType, $credentials[$loginType])->where('country_id',$countryId)->first();
            if ($admin && Hash::check($credentials['password'], $admin->password)) {
                $data = $this->adminLogin($admin);
                if (!$data['status']){
                    return $data['message'];
                }
                $response_data = $data['response_data'];
            }else{
                return sendResponse(false, __('users.invalid_phone_password'), [], '', 401);
            }
            return sendResponse(true, trans('users.login_success'), $response_data);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null,$em, 500);
        }
    }

    private function prepareLoginCredentials($login_data): array
    {
        $loginType = filter_var($login_data['login_data'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return [$loginType => $login_data['login_data'], 'password' => $login_data['password']];
    }

    private function userLogin($user,$login_data,$countryId)
    {
        $accessToken = $user->createToken('user-token')->plainTextToken;

//        if ($user->country_id != $countryId){
//            return [
//                'status'    => false,
//                'message'   => response()->json([
//                    'status'=>false,
//                    'message'=>__("You are outside the geographical area of this application."),
//                ],500)
//            ];
//        }

        if($user->email_verified_at == null) {
            return [
                'status'    => false,
                'message'   => response()->json([
                    'status'=>false,
                    'message'=>__("Kindly confirm your email address."),
                    'is_verify'=>false
                ],401)
            ];
        }
        if(!$user->status) {
            return [
                'status'    => false,
                'message'   => sendResponse(false, __("Your account is still waiting to be activated by the administrator."), [],'', 400)
            ];
        }
        if($user->block) {
            return [
                'status'    => false,
                'message'   => sendResponse(false, __("Your account is blocked by the administrator because ") . $user->block_reason, [],'', 400)
            ];
        }
        if (array_key_exists('fcm', $login_data)){
            $user->update([
                'fcm'=>$login_data['fcm']
            ]);
        }
        return [
            'status'    => true,
            'response_data'=>[
                'user'      => new UserResource($user),
                'token'     => $accessToken,
            ]
        ];

    }
    private function adminLogin($admin)
    {
        if(!$admin->status) {
        return [
            'status'    => false,
            'message'   => sendResponse(false, __("Sorry, your account has been suspended by the admin."), [],'', 400)
        ];
    }
        $accessToken = $admin->createToken('admin-2-token')->plainTextToken;
        return [
            'status'    => true,
            'response_data'=>[
                'user'      => new AdminResource($admin),
                'token'     => $accessToken,
            ]
        ];

    }

}
