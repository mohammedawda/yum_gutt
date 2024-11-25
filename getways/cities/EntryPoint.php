<?php

namespace getways\cities;

use getways\cities\logic\CityLogic;
use getways\cities\repositories\CityRepository;
class EntryPoint
{
    public $cities_obj;
    public function __construct()
    {
        $this->cities_obj = new CityLogic(new CityRepository());
    }
    
    public function cities($request)
    {
        $cities_obj = new CityLogic(new CityRepository());
        return $cities_obj->cities($request);
    }

    public function for_cities($data,$logicFunction)
    {
        return $this->cities_obj->$logicFunction($data);
    }
}
