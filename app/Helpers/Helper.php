<?php

use getways\users\models\User;

if (!function_exists('getSkipTake')) {
    function getSkipTake($request)
    {
        $skip = 0;$take = 10;
        if(!empty($request->take)) {
            $take = ($request->take > 10000 ) ? 150 : ($request->take == -1 ? 150 : $request->take) ;
        }
        if(!empty($request->skip)) {
            $skip = $request->skip > 10000 ? 150 : $request->skip;
        }
        return ['skip' => $skip, 'take' => $take];
    }
}

if (!function_exists('getDistance')) {
    function getDistance($userLat, $userLong, $itemLoat, $itemLong)
    {
        $R      = 6371; // Radius of the earth in km
        $dLat   = deg2rad($itemLoat - $userLat);  // deg2rad below
        $dLon   = deg2rad($itemLong - $userLong);
        $a      =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($userLat)) * cos(deg2rad($itemLoat)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c      = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($R * $c, 0); // Distance in km
    }
}

if (!function_exists('customRound')) {
    function customRound($number, $number_after_dot = 2): float
    {
        return round($number,$number_after_dot);
    }
}
if (!function_exists('otp_generate')) {
    function otp_generate(): string
    {
        if(config('app.payment_mode') == 'change'){
            $number = mt_rand(100000, 999999);
            if (User::where('otp', $number)->exists()) {
                otp_generate();
            }
        }else{
            $number = '123456';
        }
        return $number;
    }
}

if(!function_exists('getTakedCollection')) {
    function getTakedCollection($collection, $requestData)
    {
        $data['total'] = $collection->count();
        $take  = !empty($requestData['take']) ? $requestData['take'] : 10;
        $take  = ($take == -1) ? 50000000 : $take;
        $skip  = !empty($requestData['skip']) ? $requestData['skip'] : 0;
        $data['list']  = $collection->skip($skip)->take($take);
        $data['count'] = $data['list']->count();
        return $data;
    }
}

if(!function_exists('getTakedPreparedCollection')) {
    function getTakedPreparedCollection($collection, $requestData)
    {
        $data['total'] = $collection->count();
        $asc   = isset($requestData['asc']) ? ($requestData['asc']) : 0;
        $take  = isset($requestData['take']) ? ($requestData['take']) : 10;
        $take  = ($take == -1) ? 50000000 : $take;
        $skip  = isset($requestData['skip']) ? $requestData['skip'] : 0;
        $data['list']  = $collection->skip($skip)->take($take)
            ->when($asc == '1', function($query) {
                $query->orderBy('id', 'asc');
            })
            ->when($asc == '0', function($query) {
                $query->orderBy('id', 'desc');
            })
            ->get();
        $data['count'] = $data['list']->count();
        return $data;
    }
}

if(!function_exists('removeFirstZeroFromPhone')) {
    function removeFirstZeroFromPhone($phone): string
    {
        return ltrim($phone, '0');
    }
}

if(!function_exists('getProductPriceDetails')) {
    function getProductPriceDetails($product)
    {
        $manufacturePrice = $product->manufacture->price;
        $productWeight    = $product->weight;
        $localGoldPrice   = ($productWeight == 31.1) ? $product->localGoldPrice->ounce : $product->localGoldPrice->high_price * $productWeight;
        #ther is no global prices for 21k
        $globalGoldPrice  = ($productWeight == 31.1) ? $product->globalGoldPrice?->ounce : ((is_null($product->globalGoldPrice)) ? null : $product->globalGoldPrice?->high_price * $productWeight);
        $taxes            = $product->globalGoldPrice?->taxes;
        return [
            'local_without_manufacture' => $localGoldPrice,
            'local_with_manufacture'    => ($localGoldPrice) + ($productWeight * $manufacturePrice),
            'global_without_manufacture'=> $globalGoldPrice,
            'global_with_manufacture'   => is_null($globalGoldPrice) ? null : ($globalGoldPrice) + ($manufacturePrice * $productWeight) + ($taxes ?? 0),
        ];
    }
}
