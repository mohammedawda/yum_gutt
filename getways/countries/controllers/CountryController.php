<?php

namespace getways\countries\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function countries(Request $request)
    {
        return loadGetway('countries')->countries($request->all());
    }
}
