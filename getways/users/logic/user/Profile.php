<?php

namespace getways\users\logic\user;

use Exception;
use getways\users\resources\StoreProfileResource;
use Illuminate\Support\Facades\Auth;

class Profile extends BaseUser
{
    public function storeProfile()
    {
        try {
            $userId = Auth::id();
            $user = $this->getUserIfExist($userId);
            return sendResponse(true, __('User details'), new StoreProfileResource($user));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying User details, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}