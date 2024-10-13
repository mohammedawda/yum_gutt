<?php

namespace getways\cores;

use getways\cores\logic\CityLogic;
use getways\cores\logic\GeneralLogic;
use getways\cores\logic\RoleLogic;
use getways\cores\repositories\CityRepository;
use getways\cores\repositories\GeneralRepository;
use getways\cores\repositories\RoleRepository;

class EntryPoint
{
    public $cities_obj;
    public $roles_obj;
    public function __construct()
    {
        $this->cities_obj = new CityLogic(new CityRepository());
        $this->roles_obj = new RoleLogic(new RoleRepository());
    }
    public function payment_method($request)
    {
        $payment_method_obj = new GeneralLogic(new GeneralRepository());
        return $payment_method_obj->paymentMethods($request);
    }
    public function cities($request)
    {
        $cities_obj = new GeneralLogic(new GeneralRepository());
        return $cities_obj->cities($request);
    }
    public function countries($request)
    {
        $countries_obj = new GeneralLogic(new GeneralRepository());
        return $countries_obj->countries($request);
    }

    public function for_cities($data,$logicFunction)
    {
        return $this->cities_obj->$logicFunction($data);
    }
    public function for_permissions($data,$logicFunction)
    {
        return $this->roles_obj->$logicFunction($data);
    }


}
