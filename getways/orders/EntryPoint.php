<?php

namespace getways\orders;

use getways\orders\logic\OrdersManager;

class EntryPoint
{
    public function ordersToDeliver($filter)
    {
        return (new OrdersManager())->ordersToDeliver($filter);
    }

    public function storeOrders($filter)
    {
        return (new OrdersManager())->storeOrders($filter);
    }
}