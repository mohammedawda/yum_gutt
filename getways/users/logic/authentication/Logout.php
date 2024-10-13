<?php

namespace getways\users\logic\authentication;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function logout($logout_data)
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();;
        }
        return sendResponse(true, trans('Successfully logged out'), []);
    }
}