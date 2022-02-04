<?php

namespace App\Resources\Payments\Selects;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentSelectResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => implode(' ', [
                $this->country->name,
                $this->drop,
                $this->type->title,
                $this->sum . ' ' . $this->currency
            ])
        ];
    }
}
