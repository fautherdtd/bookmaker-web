<?php

namespace App\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentsResources extends JsonResource
{
    public function toArray($request)
    {
        return PaymentResources::collection($this->resource);
    }
}
