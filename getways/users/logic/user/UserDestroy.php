<?php

namespace getways\users\logic\user;

use Exception;

class UserDestroy extends BaseUser
{
    public function deleteUser($userId)
    {
        try {
            $user = $this->userRepository->get_user_data($userId);
            if(!$user) {
                throw new Exception(__('User not found'), 404);
            }
            $this->userRepository->deleteUserByObject($user);
            return sendMessage(true, __('Deleted Successfully'));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while deleting this User, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}