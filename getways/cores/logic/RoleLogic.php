<?php

namespace getways\cores\logic;

use Exception;
use getways\cores\repositories\CityRepository;
use getways\cores\repositories\RoleRepository;
use getways\cores\resources\CityResource;
use getways\cores\resources\PermissionResource;
use getways\cores\resources\RoleResource;
use getways\cores\resources\RoleShowResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleLogic
{
    public $resource = RoleResource::class;
    public $repository ;
    public function __construct(private readonly RoleRepository $roleRepository)
    {
        $this->repository = $this->roleRepository;
    }
    public function all_permission($request)
    {
        try {
            $permissions = $this->repository->all_permission($request);
            return sendResponse(true, __('All permissions'), PermissionResource::collection($permissions));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all_permissions_exception'), null, $em, 500);
        }
    }
    public function admin_permissions($request)
    {
        try {
            $permissions = $this->repository->admin_permissions($request);
            return sendResponse(true, __('All permissions'), PermissionResource::collection($permissions));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all_permissions_exception'), null, $em, 500);
        }
    }
    public function index($request)
    {
        try {
            $index_data = $this->repository->index($request);
            return sendResponse(true, __('All roles'), RoleResource::collection($index_data));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('roles_exception'), null, $em, 500);
        }
    }
    public function Store($request)
    {
        try {
            $validate = $request->validated();
            $validate['guard_name'] = 'admin';
            $stored_data = $this->repository->Store($validate);
            $record = $this->repository->getRecord($stored_data->id);
            if ($record['status']){
                return sendResponse(true, __('Created successfully'), new RoleShowResource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('store_roles_exception'), null, $em, 500);
        }
    }
    public function Show($request)
    {
        try {
            $record = $this->repository->getRecord($request);
            if ($record['status']){
                return sendResponse(true, __('Created successfully'), new RoleShowResource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('show_roles_exception'), null, $em, 500);
        }
    }
    public function Update($data)
    {
        $request = $data['request'];
        $validate = $request->validated();
        $id = $data['id'];
        if ($id == '1'){
            return sendResponse(false, __('Updating this role is not possible.'), null, null, 500);
        }
        try {
            $this->repository->Update($validate,$id);
            $record = $this->repository->getRecord($id);
            if ($record['status']){
                return sendResponse(true, __('Created successfully'), new $this->resource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('update_roles_exception'), null, $em, 500);
        }
    }
    public function Destroy($data)
    {
        $id = $data['id'];

        if ($id == '1'){
            return sendResponse(false, __('Deleting this role is not possible.'), null, null, 500);
        }
        try {
            $record = $this->repository->Destroy($id);
            if ($record['status']){
                return sendResponse(true, __('Deleted successfully'), null, null, 200);
            }else{
                return sendResponse($record['status'], $record['message'], null, null, 500);
            }
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('delete_roles_exception'), null, $em, 500);
        }
    }

}
