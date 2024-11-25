<?php

namespace getways\stores\resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'total_products' => $this->products_count ?? 0,
            'total_orders'   => count($this->orders),
            'today_orders'   => $this->orders->isNotEmpty() ? count($this->orders?->whereDate('created_at', Carbon::now()->format('Y-m-d'))) : 0,
            'total_revenue'  => $this->orders?->sum('total_price') ?? 0,
        ];
    }
}
