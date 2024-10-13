<?php

namespace getways\users\resources;

use App\Support\Traits\WithPagination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTransactionsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data =  [
            'id'                => $this->id,
            'user_phone'        => $this->user_phone,
            'reference_number'  => $this->reference_number,
            'transfer_photo'    => $this->image_url,
            'amount'            => $this->amount,
            'type'              => $this->typeString(),
            'reason'            => $this->reason,
            'payment_method'    => new PaymentMethodResource($this->payment_method),
            'action' => new ActionResource($this),

        ];
        if (request()->routeIs('users.transactions')){
            $data['user'] = new UserResource($this->user);
        }
        return $data;
    }
}
