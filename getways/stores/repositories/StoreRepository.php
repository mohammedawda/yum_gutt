<?php

namespace getways\stores\repositories;

use getways\stores\models\Store;

class StoreRepository
{
    public function getStoreStatistics($storeId)
    {
        return Store::where('id', $storeId)->withCount('products')->with('orders:id,store_id,total_price')->select('id')->first();
    }

    public function createStoreExtension($insert)
    {
        return Store::insert($insert);
    }
}