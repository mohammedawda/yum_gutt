<?php

namespace getways\stores\controllers;

use App\Http\Controllers\Controller;

class StoresController extends Controller
{
    public function getStats()
    {
        return loadGetway('stores')->getStats();
    }

    public function adjustStoreAvailabilityStatus()
    {
        return loadGetway('stores')->adjustStoreAvailabilityStatus();
    }
}