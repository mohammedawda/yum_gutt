<?php

namespace getways\countries;

use getways\countries\repositories\CountryRepository;
use getways\countries\logic\CountryLogic;
class EntryPoint
{
    public function payment_method($request)
    {
        $payment_method_obj = new GeneralLogic(new GeneralRepository());
        return $payment_method_obj->paymentMethods($request);
    }

    public function countries($request)
    {
        $countries_obj = new CountryLogic(new CountryRepository());
        return $countries_obj->countries($request);
    }

    public function for_permissions($data,$logicFunction)
    {
        return $this->roles_obj->$logicFunction($data);
    }


}
