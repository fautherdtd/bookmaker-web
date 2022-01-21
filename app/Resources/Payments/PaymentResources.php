<?php

namespace App\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'drop' => $this->drop,
            'bet' => $this->bk->bet->name,
            'type' => $this->type->title,
            'cash' => $this->sum . ' ' . $this->currency,
            'sum' => [
                'sum' => $this->sum,
                'currency' => $this->currency
            ],
            'currencies' => $this->currencies->name,
            'status' => $this->statuses,
            'updated_at' => !is_null($this->updated_at) ?
                $this->updated_at->format('d.m.Y') :
                $this->created_at->format('d.m.Y')
        ];
    }
}
