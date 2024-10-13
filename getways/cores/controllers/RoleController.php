<?php

namespace getways\cores\controllers;

use App\Http\Controllers\Controller;
use getways\cores\requests\CreateCityRequest;
use getways\cores\requests\CreateRoleRequest;
use getways\cores\requests\UpdateCityRequest;
use getways\cores\requests\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function all_permissions(Request $request)
    {
        return loadGetway('cores')->for_permissions($request,'all_permission');
    }
    public function admin_permissions(Request $request)
    {
        return loadGetway('cores')->for_permissions($request,'admin_permissions');
    }
    public function index(Request $request)
    {
        return loadGetway('cores')->for_permissions($request,'index');
    }
    public function store(CreateRoleRequest $request)
    {
        return loadGetway('cores')->for_permissions($request,'store');
    }
    public function show(Request $request,$id)
    {
        return loadGetway('cores')->for_permissions($id,'Show');
    }
    public function update(UpdateRoleRequest $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_permissions($data,'Update');
    }
    public function change_status(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_permissions($data,'changeStatus');
    }
    public function destroy(Request $request,$id)
    {
        $data = [
            'id'=>$id,
            'request'=>$request
        ];
        return loadGetway('cores')->for_permissions($data,'Destroy');
    }

}
