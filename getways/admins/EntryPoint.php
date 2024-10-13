<?php

namespace getways\admins;

use getways\admins\logic\AdminLogic;
use getways\admins\repositories\AdminRepository;

class EntryPoint
{
    public $admins_obj;
    public function __construct()
    {
        $this->admins_obj = new AdminLogic(new AdminRepository());
    }
    public function for_admins($data,$logicFunction)
    {
        return $this->admins_obj->$logicFunction($data);
    }


}
