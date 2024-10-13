<?php

namespace getways\cores\logic;

use App\Mail\VerifyEmail;
use Exception;
use getways\cores\models\PaymentMethodGroup;
use getways\cores\repositories\GeneralRepository;
use getways\cores\resources\CityResource;
use getways\cores\resources\CountryResource;
use getways\cores\resources\PaymentMethodGroupResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GeneralLogic
{
    public function __construct(private readonly GeneralRepository $generalRepository)
    {
    }
    public function paymentMethods($request)
    {
        try {
            $payment_methods = $this->generalRepository->payment_method($request);
            if ($payment_methods) {

                return sendResponse(true, __('Payment methods'),
                    PaymentMethodGroupResource::collection($payment_methods)
                );
            } else {
                return sendResponse(true, __('Created successfully'), []);
            }
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('users.login_exception'), null, $em, 500);
        }
    }

    public function cities($request)
    {
        try {
            $criteria = $this->generalRepository->cities($request);

            return sendListResponse(true, __('All cities'), $criteria['count'], $criteria['total'], CityResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('cities_exception'), null, $em, 500);
        }
    }


    public function countries($request)
    {
        try {
            $criteria = $this->generalRepository->countries($request);

            return sendListResponse(true, __('All countries'), $criteria['count'], $criteria['total'], CountryResource::collection($criteria['list']));
        } catch (Exception $e) {
            $em = $e->getMessage() . ' ' . $e->getFile() . '  ' . $e->getLine();
            Log::debug($em);
            return sendResponse(false, __('countries_exception'), null, $em, 500);
        }
    }

}
