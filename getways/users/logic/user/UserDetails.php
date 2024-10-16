<?php

namespace getways\users\logic\user;

use Exception;
use getways\users\resources\UserResource;
class UserDetails extends BaseUser
{
    public function userFind($userId)
    {
        try {
            $user = $this->getUserIfExist($userId);
            return sendResponse(true, __('User details'), new UserResource($user));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying User details, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}