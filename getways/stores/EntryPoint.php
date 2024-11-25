<?php

namespace getways\stores;

use getways\stores\logic\CreateStore;
use getways\stores\logic\StoreStatistics;
use getways\stores\repositories\StoreRepository;

class EntryPoint
{
    public function createStoreExtension($user, $data)
    {
        return (new CreateStore(new StoreRepository()))->createStoreExtension($user, $data);
    }
    
    public function getStats()
    {
        return (new StoreStatistics(new StoreRepository()))->getStats();
    }

    public function adjustStoreAvailabilityStatus()
    {
        return (new StoreStatistics(new StoreRepository()))->adjustStoreAvailabilityStatus();
    }
}