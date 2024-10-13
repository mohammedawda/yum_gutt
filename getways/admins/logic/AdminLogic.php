<?php

namespace getways\admins\logic;

use Exception;
use getways\admins\repositories\AdminRepository;
use getways\admins\resources\AdminCurrencyResource;
use getways\admins\resources\AdminResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminLogic
{
    public $resource = AdminResource::class;
    public $repository ;
    public function __construct(private readonly AdminRepository $adminRepository)
    {
        $this->repository = $this->adminRepository;
    }
    public function index($request)
    {
        try {
            $criteria = $this->repository->index($request);

            return sendListResponse(true, __('All admins'), $criteria['count'], $criteria['total'], $this->resource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('admins_exception'), null, $em, 500);
        }
    }
    public function Store($request)
    {
        try {
            $validate = $request->validated();
            $validate['phone'] = removeFirstZeroFromPhone($validate['phone']);
            $validate['full_phone'] = $validate['country_code'] . $validate['phone'];
            $password = Arr::pull($validate, 'password');
            $validate['password'] = Hash::make($password);
            $validate['password_str'] = $password;

            $admin = \getways\users\models\Admin::where('full_phone', $validate['full_phone'])->first();
            if($admin){
                return response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => __('This phone is used before.'),
                ], 403);
            }
            $validate['country_id'] = Auth::guard('admin')->user()->country_id;
            $stored_data = $this->repository->Store($validate);
            $record = $this->repository->getRecord($stored_data->id);
            if ($record['status']){
                return sendResponse(true, __('Created successfully'), new $this->resource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('store_admins_exception'), null, $em, 500);
        }
    }
    public function Show($request)
    {
        try {
            $record = $this->repository->getRecord($request);
            if ($record['status']){
                return sendResponse(true, __('Created successfully'), new $this->resource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('show_admins_exception'), null, $em, 500);
        }
    }
    public function Update($data)
    {
        $request = $data['request'];
        $validate = $request->validated();
        $id = $data['id'];
        $record = $this->repository->getRecord($id);
        if (!$record['status']){
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        }
        $result = $this->prepare_validations($request, $validate,$id);
        if (!$result['status']){
            return $result['validate'];
        }
        $validate = $result['validate'];
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
            return sendResponse(false, __('update_admins_exception'), null, $em, 500);
        }
    }
    public function changeStatus($data)
    {
        $id = $data['id'];
        try {
            $this->repository->changeStatus($id);
            $record = $this->repository->getRecord($id);
            if ($record['status']){
                return sendResponse(true, __('The status is changed successfully.'), new $this->resource($record['record']), null, 200);
            }
            return sendResponse(false, __('We did not find this data.'), null, null, 500);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('status_admins_exception'), null, $em, 500);
        }
    }
    public function Destroy($data)
    {
        $id = $data['id'];
        try {
            $this->repository->Destroy($id);
            return sendResponse(true, __('Deleted successfully'), null, null, 200);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('delete_admins_exception'), null, $em, 500);
        }
    }

     function prepare_validations(mixed $request, mixed $validate,$id)
    {

        if ($request->has('password')){
            $password = Arr::pull($validate, 'password');
            $validate['password'] = Hash::make($password);
            $validate['password_str'] = $password;
        }

        if ($request->has('phone') && $request->has('country_code')){
            $validate['phone'] = removeFirstZeroFromPhone($validate['phone']);
            $validate['full_phone'] = $validate['country_code'] . $validate['phone'];
            $admin = \getways\users\models\Admin::where('full_phone', $validate['full_phone'])->where('id', '!=' ,$id)->first();
            if($admin){
                return [
                'status'=>false,
                'validate'=> response()->json([
                    'status' => false,
                    'code' => 403,
                    'message' => __('This phone is used before.'),
                ], 403)
            ];
            }
        }
        return [
            'status'=>true,
            'validate'=>$validate
        ];
    }

    public function getAdminCurrency($admin)
    {
        try {
            if (!$admin){
                throw new Exception(__('Admin not found'), 404);
            }
            return sendResponse(true, __('Admin currency'), new AdminCurrencyResource($admin));
        } catch (Exception $e) {
            $em = $e->__toString();
            $error = is_string($e->getCode());
            Log::debug($em);
            return sendResponse(false, $e->getMessage() ?? __('Sorry an error occured while displaying admin currency data, please try again later'),
            null, $em, ($error) ? 500 : $e->getCode() ?? 500);
        }
    }
}
