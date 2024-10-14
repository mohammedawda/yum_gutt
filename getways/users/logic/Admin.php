<?php

namespace getways\users\logic;

use Exception;
use getways\users\repositories\AdminRepository;
use getways\users\resources\UserAnswerResource;
use getways\users\resources\UserDetailsResource;
use getways\users\resources\UserResource;
use getways\users\resources\UserTransactionsResource;
use Illuminate\Support\Facades\Log;

class Admin
{
    public function __construct(private readonly AdminRepository $adminRepository )
    {
    }
    public function Transactions($request)
    {
        try {
            $criteria = $this->adminRepository->usersTransactions($request);
            return sendListResponse(true, __('All users transactions'), $criteria['count'], $criteria['total'], UserTransactionsResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all user transactions exception'), null, $em, 500);
        }
    }

    public function TransactionBlock($request)
    {
        try {
            return $this->adminRepository->transactionBlock($request);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all user exception'), null, $em, 500);
        }
    }

    public function TransactionActive($request)
    {
        try {
            return $this->adminRepository->transactionActive($request);
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('all user exception'), null, $em, 500);
        }
    }

}
