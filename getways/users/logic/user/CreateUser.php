<?php

namespace getways\users\logic\user;

use App\Mail\VerifyEmail;
use Exception;
use getways\users\resources\UserResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            DB::rollback();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while creating this user, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
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