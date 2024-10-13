<?php

namespace App\Support\Factory\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class PaymentFactory
{
    abstract public function generatePaymentLink($data);
    abstract public function handleCallback($user,$amount);
    abstract public function createOnlinePaymentRecord($user_id,$order_id,$amount);

    /**
     * Handles the payment request to the PayTaps API.
     *
     * @param string $callbackidentifier The callback identifier to be called after the payment process for specific goal.
     * @param int $amount The amount to be paid.
     * @param string $userName The name of the user making the payment.
     * @param array $cart The cart details.
     *
     * @param int $cart['id'] The unique identifier of the cart.
     * @param string $cart['desc'] A description of the cart.
     */
    protected function payTapsApi(string $callbackidentifier, int $amount, $user, array $cart)
    {
        try {
            $server_key = config('app.' . config('app.payment_mode') . 'ServerKey');
            $profile_id = 97965;

            $curl = curl_init();

            $payload = json_encode([
                "profile_id" => intval($profile_id),
                "tran_type" => "sale",
                "tran_class" => "ecom",
                "cart_id" => str($cart['id']),
                "cart_description" => $cart['desc'],
                "cart_currency" => "EGP",
                "cart_amount" => intval($amount),
                "callback" => route('payTapsCallback', ['type' => $callbackidentifier]),
                "customer_details" => [
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ]);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://secure-egypt.paytabs.com/payment/request',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    'authorization: ' . $server_key,
                    'content-type: application/json',
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            // Handle the response
            if ($response) {
                return json_decode($response);
            } else {
                return response()->json(['error' => 'Empty response from payment gateway'], 500);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Payment request exception: ' . $e->getMessage());

            return response()->json(['error' => 'An unexpected error occurred during the payment request'], 500);
        }
    }
    protected function payTapsInstallmentApi(string $callbackidentifier, int $amount, string $user_name, array $cart)
    {
        try {
            $server_key = "SBJ99LTTDD-JH9MBZJL6D-BK66DRD9L2";
            $profile_id = 135261;

            $curl = curl_init();

            $payload = json_encode([
                "profile_id" => intval($profile_id),
                "tran_type" => "sale",
                "tran_class" => "ecom",
                "cart_id" => str($cart['id']),
                "cart_description" => $cart['desc'],
                "cart_currency" => "EGP",
                "cart_amount" => intval($amount),
                "callback" => route('payTapsCallback', ['type' => $callbackidentifier]),
                "customer_details" => [
                    "name" => $user_name
                ]
            ]);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://secure-egypt.paytabs.com/payment/request',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    'authorization: ' . $server_key,
                    'content-type: application/json',
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            // Handle the response
            if ($response) {
                return json_decode($response);
            } else {
                return response()->json(['error' => 'Empty response from payment gateway'], 500);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Payment request exception: ' . $e->getMessage());

            return response()->json(['error' => 'An unexpected error occurred during the payment request'], 500);
        }
    }

//    protected function payTapsApi(string $callbackidentifier, int $amount,string $user_name,array $cart)
//    {
//        try {
//            $server_key = config('app.'.config('app.payment_mode').'ServerKey');
//            $profile_id = 97965;
//
//                $curl = curl_init();
//
//                curl_setopt_array($curl, array(
//                    CURLOPT_URL => 'https://secure-egypt.paytabs.com/payment/request',
//                    CURLOPT_RETURNTRANSFER => true,
//                    CURLOPT_ENCODING => '',
//                    CURLOPT_MAXREDIRS => 10,
//                    CURLOPT_TIMEOUT => 0,
//                    CURLOPT_FOLLOWLOCATION => true,
//                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                    CURLOPT_CUSTOMREQUEST => 'POST',
//                    CURLOPT_POSTFIELDS =>'{
//                    "profile_id": '.$profile_id.',
//                    "tran_type": "sale",
//                    "tran_class": "ecom" ,
//                    "cart_id":'.$cart['id'].',
//                    "cart_description": '.$cart['desc'].',
//                    "cart_currency": "EGP",
//                    "cart_amount": '.$amount.',
//                    "callback": '.route('payTapsCallback',"type=$callbackidentifier").',
//                    "customer_details": {
//                      "name": '.$user_name.'
//                    }
//                }',
//                    CURLOPT_HTTPHEADER => array(
//                        'authorization: '.$server_key,
//                        'content-type: application/json',
//                        'Content-Type: application/octet-stream'
//                    ),
//                ));
//
//                $response = curl_exec($curl);
//
//                curl_close($curl);
//
//            // Handle the response
//            if ($response->successful()) {
//                $response_decoded = json_decode($response);
//                return $response_decoded->redirect_url;
//            } else {
//                return response()->json(['error' => 'Payment request failed'], 500);
//            }
//        } catch (\Exception $e) {
//            // Log the exception
//            Log::error('Payment request exception: ' . $e->getMessage());
//
//            return response()->json(['error' => 'An unexpected error occurred during the payment request'], 500);
//        }
//    }
}
