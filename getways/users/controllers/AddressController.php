<?php

namespace getways\users\controllers;

use App\Http\Controllers\Controller;
use getways\users\requests\CreateAddressRequest;
use getways\users\requests\UpdateAddressRequest;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        return loadGetway('users')->for_address($request,'index');
    }
    public function store(CreateAddressRequest $request)
    {
        return loadGetway('users')->for_address($request,'store');
    }
    public function show(Request $request,$id)
    {
        return loadGetway('users')->for_address($id,'Show');
    }
    public function update(UpdateAddressRequest $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('users')->for_address($data,'Update');
    }
    public function change_status(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('users')->for_address($data,'changeStatus');
    }
    public function destroy(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('users')->for_address($data,'Destroy');
    }

}
