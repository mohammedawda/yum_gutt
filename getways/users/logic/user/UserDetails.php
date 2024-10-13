<?php

namespace getways\users\logic\user;

use Exception;
use getways\users\resources\UserDetailsResource;
use Illuminate\Support\Facades\Log;

class UserDetails extends BaseUser
{
    public function showUserForAdmin($id)
    {
        try {
            $user = $this->userRepository->get_user_data($id);
            if($user) {
                throw new Exception(__('User not found'), 404);
            }
            return sendResponse(true, __('Show user'), new UserDetailsResource($user));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all user exception'), null, $em, 500);
        }
    }
}