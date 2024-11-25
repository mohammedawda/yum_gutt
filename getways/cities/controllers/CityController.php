<?php

namespace getways\cities\controllers;

use App\Http\Controllers\Controller;
use getways\cores\requests\CreateCityRequest;
use getways\cores\requests\UpdateCityRequest;
use getways\users\requests\CreateUserRequest;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        return loadGetway('cores')->for_cities($request,'index');
    }
    public function store(CreateCityRequest $request)
    {
        return loadGetway('cores')->for_cities($request,'store');
    }
    public function show(Request $request,$id)
    {
        return loadGetway('cores')->for_cities($id,'Show');
    }
    public function update(UpdateCityRequest $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_cities($data,'Update');
    }
    public function change_status(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_cities($data,'changeStatus');
    }
    public function destroy(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_cities($data,'Destroy');
    }

    public function cities(Request $request)
    {
        return loadGetway('cities')->cities($request->all());
    }
}
