<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\ChangePasswordRequest;
use getways\users\requests\LoginRequest;
use getways\users\requests\StoreRegisterRequest;
use getways\users\requests\UserRegisterRequest;
use getways\users\requests\ResetRequest;
use getways\users\requests\SendVerifyRequest;
use getways\users\requests\VerifyRequest;
class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return loadGetway('users')->login($request->validated());
    }

    public function admin_login(LoginRequest $request)
    {
        return loadGetway('users')->admin_login($request->validated());
    }
    
    public function storeRegister(StoreRegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['role_id'] = 2;
        return loadGetway('users')->register($validated);
    }

    public function userRegister(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['role_id'] = 3;
        return loadGetway('users')->register($validated);
    }

    public function reset(ResetRequest $request)
    {
        return loadGetway('users')->reset($request->all());
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $reset_data = $request->all();
        return loadGetway('users')->changePassword($reset_data);
    }

    public function verify_user(VerifyRequest $request)
    {
        $verify_data = $request->validated();
        return loadGetway('users')->verify($verify_data);
    }

    public function send_verify_user(SendVerifyRequest $request)
    {
        $verify_data = $request->validated();
        return loadGetway('users')->SendVerify($verify_data);
    }

    public function reset_password(SendVerifyRequest $request)
    {
        $verify_data = $request->validated();
        return loadGetway('users')->SendVerify($verify_data);
    }

    public function logout()
    {
        return loadGetway('users')->logout();
    }
}
