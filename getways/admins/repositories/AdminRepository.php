<?php

namespace getways\admins\repositories;

use getways\users\models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AdminRepository
{
    public $model = Admin::class;
    public function index($request)
    {
        $rows = getSkipTake($request);
        $countryId = config('app.country_id');
        if (!Auth::guard('admin')->user()->is_suber_admin){
            $admins = $this->model::Query();
        }else{
            $admins = $this->model::where('country_id',$countryId)->where('is_super_admin','1');
        }
        $admins =$admins
            ->when($request->desc, function($query) {
                $query->orderByDesc('id');
            })
            ->when($request->country_id, function($query) use($request){
                $query->where('country_id', $request->country_id);
            })
            ->when($request->status, function($query) use($request){
                $query->where('status', $request->status);
            })
            ->when($request->name, function($query) use($request){
                $query->where('name', $request->name);
            })
            ->when($request->email, function($query) use($request){
                $query->where('email', $request->email);
            })
            ->when($request->phone, function($query) use($request){
                $query->where('phone', $request->phone);
            })
            ->when($request->has('withRole'), function($query) use($request){
                $query->role($request->withRole);
            })
            ->when($request->has('withoutRole'), function($query) use($request){
                $query->withoutRole($request->withoutRole);
            })
        ;
        $criteria['total'] = $admins->count();
        $criteria['list']  = $admins->skip($rows['skip'])->take($rows['take'])->get();
        $criteria['count'] = $criteria['list']->count();
        return $criteria;
    }

    public function Store(mixed $validate)
    {
        $role = Arr::pull($validate,'role');
        $admin = $this->model::create($validate);
        $admin->assignRole($role);
        return $admin;
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
        ];
    }

    public function Update(mixed $validate,$id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $role = Arr::pull($validate,'role');
            $record['record']->update($validate);
            $admin_role = $record['record']->getRoleNames()->first();
            if ($admin_role != $role){
                if($admin_role){
                    $record['record']->removeRole($admin_role);
                }
                $record['record']->assignRole($role);
            }
            return $record['record'];
        }
    }
    public function changeStatus($id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $status = $record['record']->status ? '0' : '1';
            $record['record']->update([
                'status'=>$status
            ]);
        }
    }
    public function Destroy( $id)
    {
        $record = $this->getRecord($id);
        if ($record['status']){
            $record['record']->delete();
        }
    }

}
