<?php

namespace App\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'drop' => $this->drop,
            'bet' => $this->bk->bet->name,
            'type' => [
                'id' => $this->type->id,
                'title' => $this->type->title,
            ],
            'cash' => $this->sum . ' ' . $this->currency,
            'sum' => [
                'value' => $this->sum,
                'currency' => $this->currency
            ],
            'currencies' => $this->currencies->name,
            'status' => [
                'key' => $this->status,
                'value' => $this->statuses,
            ],
            'bk_id' => $this->bk_id,
            'updated_at' => !is_null($this->updated_at) ?
                $this->updated_at->format('d.m.Y') :
                $this->created_at->format('d.m.Y')
        ];
    }
}
