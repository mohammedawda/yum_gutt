<?php

namespace getways\users\logic\authentication;

use Exception;
use getways\users\models\User;
use getways\users\repositories\AuthRepository;
use getways\users\repositories\UserRepository;
use getways\users\resources\AdminResource;
use getways\users\resources\UserResource;
use Illuminate\Support\Facades\Hash;
class Login
{
    public function __construct(private AuthRepository $userRepository)
    {
    }

    private function getUserRepo()
    {
        return new UserRepository();
    }

    private function prepareLoginCredentials($login_data): array
    {
        $loginType = filter_var($login_data['login_data'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return [$loginType => $login_data['login_data'], 'password' => $login_data['password']];
    }

    private function getUserAttemptToLogin($credentials, $rols)
    {
        $loginType = key($credentials);
        return $this->getUserRepo()->getUserByLoginData($loginType, $credentials, $rols);
    }

    private function permitUserToLogin($user)
    {

        //        if ($user->country_id != $countryId){
        //            return [
        //                'status'    => false,
        //                'message'   => response()->json([
        //                    'status'=>false,
        //                    'message'=>__("You are outside the geographical area of this application."),
        //                ],500)
        //            ];
        //        }
        if($user->role_id != User::STORE_ROLE && $user->role_id != User::USER_ROLE)
            throw new Exception(__("Not authorized to visit this page."), 401);

        if($user->email_verified_at == null)
            throw new Exception(__("Kindly confirm your email address."), 401);

        if(!$user->status)
            throw new Exception(__("Your account is still waiting to be activated by the administrator."), 401);

        if($user->block)
            throw new Exception(__("Your account is blocked by the administrator because "), 401);
    }
    
    public function login(array $data)
    {
        try {
            $credentials = $this->prepareLoginCredentials($data);
            $user = $this->getUserAttemptToLogin($credentials, [User::STORE_ROLE, User::USER_ROLE]);
            if(!$user) {
                throw new Exception(__('Invalid login data.'), 403);
            }
            if (!Hash::check($credentials['password'], $user->password)) {
                throw new Exception(__('Invalid login data.'), 403);
            }
            $this->permitUserToLogin($user, $data);
            $accessToken = $this->generateToken($user);
            if (array_key_exists('fcm', $data)) {
                $this->getUserRepo()->updateUserByObject($user, ['fcm' => $data['fcm']]);
            }
            return sendResponse(true, trans('users.login_success'), ['user' => new UserResource($user), 'token' => $accessToken]);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('users.login_exception'), null, "", 500);
            }
            return sendResponse(false, $e->getMessage(), null, "", $e->getCode());
        }
    }

    private function permitAdminToLogin($admin)
    {
        if($admin->role_id != User::ADMIN_ROLE)
            throw new Exception(__("Not authorized to visit this page."), 401);

        if(!$admin->status) {
            throw new Exception(__("Sorry, your account has been suspended by the admin."), 401);
        }
    }

    public function admin_login(array $data)
    {
        try {
            $credentials = $this->prepareLoginCredentials($data);
            $admin = $this->getUserAttemptToLogin($credentials, [User::ADMIN_ROLE]);
            if(!$admin) {
                throw new Exception(__('Invalid login data.'), 403);
            }
            if (!Hash::check($credentials['password'], $admin->password)) {
                throw new Exception(__('Invalid login data.'), 403);
            }
            $this->permitAdminToLogin($admin);
            $accessToken = $this->generateToken($admin);
            return sendResponse(true, trans('users.login_success'), ['user' => new AdminResource($admin), 'token' => $accessToken]);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('users.login_exception'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }

    private function generateToken($user)
    {
        return $user->createToken('access-token')->plainTextToken;
    }
}
