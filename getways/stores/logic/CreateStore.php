<?php

namespace getways\stores\logic;

use Exception;
use getways\stores\repositories\StoreRepository;

class CreateStore
{
    public function __construct(private StoreRepository $storeRepository)
    {   
    }

    public function createStoreExtension($user, $data)
    {
        if(!$user) {
            throw new Exception(__('There is a problem in creating your account, please contact for more help.'), 500);
        }
        $this->prepareExtensionData($user->id, $data);
        $this->storeRepository->createStoreExtension($data);
    }

    private function prepareExtensionData($userId, &$data)
    {
        $data['user_id']       = $userId;
        $data['serial_number'] = (int)(rand(100000, 999999).$userId);
    }
}