<?php

namespace getways\users\resources;

use App\Support\Traits\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'transfer_number'   => $this->transfer_number,
            'key'               => $this->transfer_number_name,
            'image'             => $this->image_url,
        ];
    }
}
