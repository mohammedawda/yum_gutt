<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\ChangePasswordRequest;
use getways\users\requests\LoginRequest;
use getways\users\requests\RegisterRequest;
use getways\users\requests\ResetRequest;
use getways\users\requests\SendVerifyRequest;
use getways\users\requests\VerifyRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $login_data = $request->validated();
        $data = [
            'login_data' => $login_data,
            'request' => $request,
        ];
        return loadGetway('users')->login($data);
    }

    public function admin_login(LoginRequest $request)
    {
        $login_data = $request->validated();

        $data = [
            'login_data' => $login_data,
            'request' => $request,
        ];
        return loadGetway('users')->admin_login($data);
    }
    
    public function register(RegisterRequest $request)
    {
        return loadGetway('users')->register($request->validated());
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

    public function logout(Request $request)
    {
        return loadGetway('users')->logout($request);
    }
}
