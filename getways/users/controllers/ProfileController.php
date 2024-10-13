<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\UpdatePasswordRequest;
use getways\users\requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function get_data(Request $request)
    {
        return loadGetway('users')->profile();
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
