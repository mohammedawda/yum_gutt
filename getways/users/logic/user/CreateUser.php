<?php

namespace getways\users\logic\user;

use App\Mail\VerifyEmail;
use Exception;
use getways\users\resources\UserResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreateUser extends BaseUser
{
    public function createUser(array $data)
    {
        try {
            $this->uploadUserImages($data);
            $this->prepareCreateUser($data);
            $user = $this->userRepository->create_user($data);
            if (Request()->url() == route('register')) {
                $email_data = $this->prepareEmailedCreatedUser($user);
                Mail::to($user->email)->queue(new VerifyEmail($email_data));
                return sendResponse(true, __('Your registration has been completed. Kindly verify your email.'), new UserResource($user));
            }
            return sendResponse(true, __('Created successfully'), new UserResource($user));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }
    }

    private function prepareCreateUser(&$data)
    {
        $password             = Arr::pull($data, 'password');
        $data['password']     = Hash::make($password);
        $data['password_str'] = $password;
        $data['phone']        = removeFirstZeroFromPhone($data['phone']);
        $data['full_phone']   = $data['country_code'].$data['phone'];
    }

    private function prepareEmailedCreatedUser($user)
    {
        return [
            'code' => $user->otp,
            'name' => $user->name
        ];
    }
}