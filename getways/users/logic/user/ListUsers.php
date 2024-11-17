<?php

namespace getways\users\logic\user;

use Exception;
use getways\users\resources\AllUsersResource;

class ListUsers extends BaseUser
{
    public function allStores($filter)
    {
        try {
            $criteria = $this->userRepository->allUsers($filter, ['city', 'country'], 'AllStores');
            return sendListResponse(true, __('All users'), $criteria['count'], $criteria['total'], $criteria['last_page'], AllUsersResource::collection($criteria['list']));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying list stores, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }

    public function allUsers($filter)
    {
        try {
            $criteria = $this->userRepository->allUsers($filter, ['city', 'country'], 'AllUsers');
            return sendListResponse(true, __('All users'), $criteria['count'], $criteria['total'], $criteria['last_page'], AllUsersResource::collection($criteria['list']));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying list users, please try again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}