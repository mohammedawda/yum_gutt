<?php

namespace getways\stores\logic;

use Exception;
use getways\stores\repositories\StoreRepository;
use Illuminate\Support\Facades\Auth;

class StoreActions
{
    public function __construct(private StoreRepository $storeRepository)
    {   
    }

    public function adjustStoreAvailabilityStatus()
    {
        try{
            $store = $this->storeRepository->getStoreStatistics(Auth::user()->id);
            if(!$store) {
                throw new Exception(__('Store not found'), 404);
            }
            return sendResponse(true, 'Store statistics', new StoreStatisticsResource($store));
        } catch(Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying store statistics, please trg again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}