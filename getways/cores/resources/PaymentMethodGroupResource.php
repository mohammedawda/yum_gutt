<?php

namespace getways\cores\resources;

use getways\cores\resources\PaymentMethodResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodGroupResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $paymentMethods = $this->payment_methods()->where('status', '1')->where('country_id', config('app.country_id'))->get();
        return [
            'id'                => $paymentMethods->count() > 1 ? $this->id : $paymentMethods->first()->id,
            'title'             => $this->title,
            'image'             => $this->image_url,
            'transfer_number'   => $paymentMethods->count() > 1 ? $this->id : $paymentMethods->first()->transfer_number ?? "",
            'key'               => $paymentMethods->count() > 1 ? $this->id : $paymentMethods->first()->transfer_number_name ?? "",
            'payment_method'    =>  $paymentMethods->count() > 1 ? PaymentMethodResource::collection($paymentMethods) : null,
        ];
    }
}
