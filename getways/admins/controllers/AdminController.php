<?php

namespace getways\admins\controllers;

use App\Http\Controllers\Controller;
use getways\admins\requests\CreateAdminRequest;
use getways\admins\requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return loadGetway('admins')->for_admins($request,'index');
    }
    public function store(CreateAdminRequest $request)
    {
        return loadGetway('admins')->for_admins($request,'store');
    }
    public function show(Request $request,$id)
    {
        return loadGetway('admins')->for_admins($id,'Show');
    }
    public function update(UpdateAdminRequest $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('admins')->for_admins($data,'Update');
    }
    public function change_status(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('admins')->for_admins($data,'changeStatus');
    }
    public function destroy(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('admins')->for_admins($data,'Destroy');
    }

    public function getAdminCurrency()
    {
        $admin = Auth::guard('admin')->user();
        return loadGetway('admins')->for_admins($admin, 'getAdminCurrency');
    }
}
