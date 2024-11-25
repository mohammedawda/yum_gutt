<?php

namespace getways\users\logic\user;

use App\Mail\VerifyEmail;
use Exception;
use getways\users\models\User;
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
            $storeData = $this->prepareCreateUser($data);
            DB::beginTransaction();
            $user = $this->userRepository->create_user($data);
            $this->processCreateUserExtensions($user, $storeData);
            DB::commit();
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
        return $this->prepareUserExtensions($data);
    }

    private function prepareEmailedCreatedUser($user)
    {
        return [
            'code' => $user->otp,
            'name' => $user->name
        ];
    }

    private function processCreateUserExtensions($user, $data)
    {
        if($user->role_id == User::USER_ROLE)
            return true;
    
        elseif($user->role_id == User::STORE_ROLE)
            return loadGetway('stores')->createStoreExtension($user, $data);

        throw new Exception(__('Invalid user role'), 400);
    }

    private function prepareStoreUserData(&$data)
    {
        return [
            'national_id_photo'      => Arr::pull($data, 'national_id_photo'),
            'national_id_photo_type' => Arr::pull($data, 'national_id_photo_type'),
            'national_id'            => Arr::pull($data, 'national_id'),
        ];
    }

    private function prepareUserExtensions(&$data)
    {
        if(!array_key_exists('role_id', $data))
            throw new Exception(__('Invalid user role'), 400);

        if($data['role_id'] == 2)
            return $this->prepareStoreUserData($data);

        return [];
    }
}