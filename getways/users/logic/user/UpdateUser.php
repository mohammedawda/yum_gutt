<?php

namespace getways\users\logic\user;

use Exception;
use getways\users\resources\UserResource;
use Illuminate\Support\Facades\DB;

class UpdateUser extends BaseUser
{
    public function updateUser($userId, array $data)
    {
        try {
            $user = $this->getUserIfExist($userId);
            $this->processUpdateUserImages($data, $user);
            $this->prepareUpdateUser($data);
            $this->userRepository->updateUserByObject($user, $data);
            return sendResponse(true, __('Updated successfully'), new UserResource($user));
        } catch (Exception $e) {
            DB::rollback();
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while updating this user, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }

    private function prepareUpdateUser(&$data)
    {
        if(!empty($data['phone'])) {
            $data['phone']       = removeFirstZeroFromPhone($data['phone']);
            $data['full_phone']  = $data['country_code'].$data['phone'];
        }
    }

    private function processUpdateUserImages(&$data, $user)
    {
        $this->processNationalIdPhoto($user, $data);
        $this->processProfilePhoto($user, $data);
        $this->uploadUserImages($data);
    }

    private function processNationalIdPhoto($user, &$data)
    {
        if (array_key_exists('national_id_photo', $data) && !is_null($data['national_id_photo'])) {
            if(!is_null($user->national_id_photo)) {
                $oldImage = fileExists(FileDir('user_images'), $user->national_id_photo)
                ? FileDir('user_images').$user->national_id_photo : false;
                if($oldImage) {
                    unlinkFile($oldImage);
                }
            }
        }
    }

    private function processProfilePhoto($user, &$data)
    {
        if (array_key_exists('profile_photo', $data) && !is_null($data['profile_photo'])) {
            if(!is_null($user->profile_photo)) {
                $oldImage = fileExists(FileDir('profile_photo'), $user->profile_photo)
                ? FileDir('profile_photo').$user->profile_photo : false;
                if($oldImage) {
                    unlinkFile($oldImage);
                }
            }
        }
    }
}