<?php

namespace getways\cities\logic;

use Exception;
use getways\cities\repositories\CityRepository;
use getways\cities\resources\CityResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class CityLogic
{
    public $resource = CityResource::class;
    public $repository ;
    public function __construct(private readonly CityRepository $cityRepository)
    {
        $this->repository = $this->cityRepository;
    }
    public function index($request)
    {
        try {
            $criteria = $this->repository->index($request);

            return sendListResponse(true, __('All cities'), $criteria['count'], $criteria['total'], $criteria['last_page'], $this->resource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('cities_exception'), null, $em, 500);
        }
    }
    public function Store($request)
    {
        try {
            $validate = $request->validated();
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
            return sendResponse(false, __('store_cities_exception'), null, $em, 500);
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
            return sendResponse(false, __('show_cities_exception'), null, $em, 500);
        }
    }
    public function Update($data)
    {
        $request = $data['request'];
        $validate = $request->validated();
        $id = $data['id'];
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
            return sendResponse(false, __('update_cities_exception'), null, $em, 500);
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
            return sendResponse(false, __('status_cities_exception'), null, $em, 500);
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
            return sendResponse(false, __('delete_cities_exception'), null, $em, 500);
        }
    }

    
    public function cities($request)
    {
        try {
            $criteria = $this->repository->cities($request);

            return sendListResponse(true, __('All cities'), $criteria['count'], $criteria['total'], $criteria['last_page'], CityResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('cities_exception'), null, $em, 500);
        }
    }
}
