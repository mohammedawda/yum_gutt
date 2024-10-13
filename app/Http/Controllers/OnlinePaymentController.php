<?php

namespace App\Http\Controllers;

use App\Models\OnlinePayment;
use Illuminate\Http\Request;

class OnlinePaymentController extends Controller
{
    public function paymentCallback(Request $request)
    {
        OnlinePayment::first()->update([
            'callback_payment_response' => $request->all(),
        ]);
//        dd($request,$request->type);
    }
}
