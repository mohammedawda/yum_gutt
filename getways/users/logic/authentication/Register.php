<?php

namespace getways\users\logic\authentication;

use getways\users\repositories\AuthRepository;

class Register
{
    public function __construct(private AuthRepository $userRepository)
    {
    }

    public function register(array $register_data)
    {
        $this->prepareRegisterData($register_data);
        $user = \getways\users\models\User::where('full_phone', $register_data['full_phone'])->first();
        if($user) {
            return sendMessage(false, __('This phone is used before.'), "", 403);
        }
        return loadGetway('users')->CreateUser($register_data);
    }

    private function prepareRegisterData(&$register_data)
    {
        $register_data['otp']        = otp_generate();
        $register_data['phone']      = removeFirstZeroFromPhone($register_data['phone']);
        $register_data['full_phone'] = $register_data['country_code'].$register_data['phone'];
    }
}
