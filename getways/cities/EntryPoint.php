<?php

namespace getways\cores;

use getways\cores\logic\CityLogic;
use getways\cores\logic\GeneralLogic;
use getways\cores\repositories\CityRepository;
use getways\cores\repositories\GeneralRepository;

class EntryPoint
{
    public $cities_obj;
    public function __construct()
    {
        $this->cities_obj = new CityLogic(new CityRepository());
    }
    
    public function cities($request)
    {
        $cities_obj = new GeneralLogic(new GeneralRepository());
        return $cities_obj->cities($request);
    }

    public function for_cities($data,$logicFunction)
    {
        return $this->cities_obj->$logicFunction($data);
    }
}
