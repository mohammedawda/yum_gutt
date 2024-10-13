<?php

namespace getways\cores\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\CreateUserRequest;

class CountryController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        $validate = $request->validated();
        $validate['status'] = '1';
        return loadGetway('users')->CreateUser($validate);
    }

}
