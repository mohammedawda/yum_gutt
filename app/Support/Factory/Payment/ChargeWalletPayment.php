<?php

namespace App\Support\Factory\Payment;

use App\Models\OnlinePayment;
use App\Support\Factory\Payment\PaymentFactory;
use getways\users\models\User;

class ChargeWalletPayment extends PaymentFactory
{
    public function generatePaymentLink($data)
    {
        $amount = $data['request']->amount;
        $user = $data['user'];

        $online_payment = $this->createOnlinePaymentRecord($user->id, $user->id, $amount);
        $payTab_result = $this->payTapsApi('wallet',$amount,$user,[
            'id'=>$online_payment->id,
            'desc'=>"Charging the user's wallet"
        ]);
        $payment_url = $payTab_result->redirect_url;
        OnlinePayment::find($online_payment->id)->update([
            'tran_ref'=>$payTab_result->tran_ref,
            'payment_url'=>$payment_url,
            'callback_url'=>$payTab_result->callback,
            'response_from_payment'=>json_encode($payTab_result)
        ]);
        return $payment_url;
    }
    public function generateInstallmentPaymentLink($data)
    {
        $amount = $data['request']->amount;
        $user = $data['user'];

        $online_payment = $this->createOnlinePaymentRecord($user->id, $user->id, $amount);
        $payTab_result = $this->payTapsInstallmentApi('Installment',$amount,$user->name,[
            'id'=>$online_payment->id,
            'desc'=>"Charging the user's wallet"
        ]);
        $payment_url = $payTab_result->redirect_url;
        OnlinePayment::find($online_payment->id)->update([
            'tran_ref'=>$payTab_result->tran_ref,
            'payment_url'=>$payment_url,
            'callback_url'=>$payTab_result->callback,
            'response_from_payment'=>json_encode($payTab_result)
        ]);
        return $payment_url;
    }

    public function handleCallback($user,$amount)
    {
        $userModel = User::find($user->id);
        $userModel->increment('wallet', $amount);
        $userModel->wallets()->create([
            'value'=>$amount,
            'desc'=>'charge wallet form',
            'type'=>'0'
        ]);
    }

    public function createOnlinePaymentRecord($user_id,$order_id,$amount)
    {
        return OnlinePayment::create([
           'user_id'=>$user_id,
           'order_id'=>$order_id,
           'type'=>'charge wallet',
           'amount'=>$amount,
           'description'=>"user that id $user_id will charge his wallet by $amount",
        ]);
    }
}
