<?php

namespace getways\users\logic\authentication;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function logout()
    {
        $authed = Auth::user();
        if ($authed) {
            $authed->currentAccessToken()->delete();;
            $authed->tokens()->delete();
        }
        return sendResponse(true, trans('Successfully logged out'), []);
    }
}