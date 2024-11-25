<?php

namespace getways\countries\logic;

use Exception;
use getways\countries\repositories\CountryRepository;
use getways\countries\resources\CityResource;
use getways\countries\resources\CountryResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CountryLogic
{
    public $resource = CityResource::class;
    public $repository ;
    public function __construct(private readonly CountryRepository $countryRepository)
    {
        $this->repository = $this->countryRepository;
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

    public function countries($request)
    {
        try {
            $criteria = $this->repository->countries($request);
            return sendListResponse(true, __('All countries'), $criteria['count'], $criteria['total'], $criteria['last_page'], CountryResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('countries_exception'), null, $em, 500);
        }
    }

}
