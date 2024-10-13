<?php

namespace getways\cores\repositories;

use getways\users\models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public $model = Role::class;
    public function all_permission($request)
    {
        return Permission::orderBy('name', 'desc')->get();
    }
    public function admin_permissions($request)
    {
        return Auth::guard('admin')->user()->getAllPermissions();
    }
    public function index($request)
    {
        return $this->model::all();
    }

    public function Store(mixed $validate)
    {
        $permissions = Arr::pull($validate, 'permissions');
        $role = $this->model::create($validate);
        $role->syncPermissions($permissions);
        return $role;
    }

    public function getRecord($id)
    {
        $record = $this->model::find($id);
        if ($record){
            return [
                'status'=>true,
                'record'=>$record
            ];
        }
        return [
            'status'=>false,
            'message'=>__("We don't found this record.")
        ];
    }
    public function Update(mixed $validate,$id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $permissions = Arr::pull($validate, 'permissions');
            $record['record']->update($validate);
            $record['record']->syncPermissions($permissions);
        }
    }
    public function changeStatus($id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $status = $record['record'] ? '0' : '1';
            $record['record']->update([
                'status'=>$status
            ]);
        }
    }
    public function Destroy( $id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $record['record']->permissions()->detach();
            $record['record']->delete();
        }
        return $record;
    }

}
