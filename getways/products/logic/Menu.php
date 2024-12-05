<?php

namespace getways\products\logic;

use Exception;
use getways\products\repositories\ProductRepository;
use getways\products\resources\MenuDetailsResource;

class Menu
{
    public function __construct(private ProductRepository $productRepository)
    {
    }
    public function menu($filter)
    {
        try {
            $products = $this->productRepository->menu($filter, []);
            return sendListResponse(true, __('Menu list'), $products['count'], $products['total'], $products['last_page'], MenuDetailsResource::collection($products['list']));
        } catch(Exception $e) {
            if(is_string($e->getCode()) || $e->getCode() == 0) {
                return sendResponse(false, __('Sorry an error occured during display menu items, please try again later'), null, $e->__toString(), 500);
            }
            return sendResponse(false, $e->getMessage(), null, $e->__toString(), $e->getCode());
        }
    }
}
