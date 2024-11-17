<?php

namespace getways\users\logic;

use Exception;
use getways\users\repositories\AddressRepository;
use getways\users\resources\AddressResource;
use Illuminate\Http\JsonResponse;

class Address
{
    public string $resource = AddressResource::class;
    public AddressRepository $repository ;
    public function __construct(private readonly AddressRepository $addressRepository){
        $this->repository = $this->addressRepository;
    }
    public function index($request): JsonResponse
    {
        try {
            $criteria = $this->repository->index($request);
            return sendListResponse(true, __('All coupons'), $criteria['count'], $criteria['total'], $criteria['last_page'], $this->resource::collection($criteria['list']));
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendMessage(false, __('Sorry an error occurred while get all coupons, please try again later'), $e->__toString(), 500);
            }
            return sendMessage(false, $e->getMessage(), $e->__toString(), $e->getCode());
        }
    }
    public function Store($request): JsonResponse
    {
        try {
            $validate = $request->validated();
            $stored_data = $this->repository->Store($validate);
            $record = $this->repository->getRecord($stored_data->id);
            return sendResponse(true, __('Created successfully'), new $this->resource($record), null);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendMessage(false, __('Sorry an error occurred while adding coupon, please try again later'), $e->__toString(), 500);
            }
            return sendMessage(false, $e->getMessage(), $e->__toString(), $e->getCode());
        }
    }
    public function Show($request): JsonResponse
    {
        try {
            $record = $this->repository->getRecord($request);
            return sendResponse(true, __('Coupon data'), new $this->resource($record), null);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendMessage(false, __('Sorry an error occurred while get coupon data, please try again later'), $e->__toString(), 500);
            }
            return sendMessage(false, $e->getMessage(), $e->__toString(), $e->getCode());
        }
    }
    public function Update($data): JsonResponse
    {
        $validate = $data['request']->validated();
        $id = $data['id'];
        try {
            $record = $this->repository->Update($validate,$id);
            return sendResponse(true, __('Updated successfully'), new $this->resource($record), null);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendMessage(false, __('Sorry an error occurred while updating coupon, please try again later'), $e->__toString(), 500);
            }
            return sendMessage(false, $e->getMessage(), $e->__toString(), $e->getCode());
        }
    }
    public function Destroy($data): JsonResponse
    {
        $id = $data['id'];
        try {
            $this->repository->Destroy($id);
            return sendResponse(true, __('Deleted successfully'), null, null);
        } catch (Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendMessage(false, __('Sorry an error occurred while deleting coupon, please try again later'), $e->__toString(), 500);
            }
            return sendMessage(false, $e->getMessage(), $e->__toString(), $e->getCode());
        }
    }
}
