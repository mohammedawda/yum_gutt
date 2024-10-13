<?php

namespace getways\cores\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\CreateUserRequest;
use Illuminate\Http\Request;

class GeneralApiController extends Controller
{
    public function payment_method(Request $request)
    {
        return loadGetway('cores')->payment_method($request);
    }
    public function cities(Request $request)
    {
        return loadGetway('cores')->cities($request);
    }
    public function countries(Request $request)
    {
        return loadGetway('cores')->countries($request);
    }

}
