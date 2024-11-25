<?php

namespace getways\orders\logic;

use Exception;
use getways\orders\repositories\OrderRepository;
use getways\orders\resources\AllOrdersDetailsResource;
use getways\orders\resources\OrdersToDeliverResource;

class OrdersManager
{
    protected function ordersRepositoryAccessor()
    {
        return new OrderRepository();
    }

    public function ordersToDeliver($filter)
    {
        try{
            $criteria = $this->ordersRepositoryAccessor()->ordersToDeliver($filter, ['id', 'delivery_status'], ['cart.product']);
            return sendListResponse(true, 'Order to deliver', $criteria['count'], $criteria['total'], $criteria['last_page'], OrdersToDeliverResource::collection($criteria['list']));
        } catch(Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying store statistics, please trg again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }

    public function storeOrders($filter)
    {
        try{
            $criteria = $this->ordersRepositoryAccessor()->storeOrders($filter, ['id', 'delivery_status', 'order_code'], ['cart.product']);
            return sendListResponse(true, 'Store orders', $criteria['count'], $criteria['total'], $criteria['last_page'], AllOrdersDetailsResource::collection($criteria['list']));
        } catch(Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured while displaying store statistics, please trg again later.'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
