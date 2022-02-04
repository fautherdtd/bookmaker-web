<?php

namespace App\Resources\Payments\Selects;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentSelectsResources extends JsonResource
{
    public function toArray($request)
    {
        return PaymentSelectResources::collection($this->resource);
    }
}
