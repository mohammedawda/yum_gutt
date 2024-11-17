<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\UpdatePasswordRequest;
use getways\users\requests\UpdateProfileRequest;
class ProfileController extends Controller
{
    public function getStoreProfile()
    {
        return loadGetway('users')->storeProfile();
    }

    public function getUserProfile()
    {
        return loadGetway('users')->userProfile();
    }

    public function update_data(UpdateProfileRequest $request)
    {
        return loadGetway('users')->updateProfile($request);
    }
    public function update_password(UpdatePasswordRequest $request)
    {
        return loadGetway('users')->updatePassword($request);
    }

}
