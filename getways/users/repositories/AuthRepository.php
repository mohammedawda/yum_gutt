<?php

namespace getways\users\repositories;

use App\Mail\ChangePassword;
use getways\users\models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository
{
    public function insertUserGetId($userData)
    {
        return User::create($userData);
    }

    public function updateUserProfile($validate)
    {
        $validate['phone'] = removeFirstZeroFromPhone($validate['phone']);
        $validate['full_phone'] = $validate['country_code'].$validate['phone'];
        $authUser = $this->getAuthUser();
        $authUser->update($validate);
        return clone $authUser;
    }

    public function updateUserPassword($validate)
    {
        $authUser = $this->getAuthUser();
        $oldPassword = Arr::pull($validate, 'old_password');
        $password = Arr::pull($validate, 'password');
        if ($password == $authUser->password_str) {
            return [
                'status' => false,
                'message' => __('The new password must not be the same as the old password.'),
            ];
        }

        if ($oldPassword != $authUser->password_str) {
            return [
                'status' => false,
                'message' => __('The old password is incorrect.'),
            ];
        }
        $validate['password_str'] = $password;
        $validate['password'] = Hash::make($password);
        $authUser->update($validate);

        $email_data = [
//            'code' => $authUser->otp,
            'name' => $authUser->name
        ];
        Mail::to($authUser->email)->queue(new ChangePassword($email_data));
        return [
            'status'=>true,
            'data'=> clone $authUser
        ];
    }

    public function getAuthUser()
    {
        return User::find(Auth::id());
    }
}
