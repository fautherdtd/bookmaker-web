<?php

namespace App\Resources\BK;

use Illuminate\Http\Resources\Json\JsonResource;

class BkItemResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'drop' => $this->drop,
            'email' => $this->email,
            'password' => $this->password,
            'address' => $this->address,
            'document' => $this->document,
            'info' => $this->info,
            'drop_guide' => $this->drop_guide,

            'bk' => $this->bet->name,
            'payments' => $this->payments(),

            'cash' => $this->cash,
            'currencies' => $this->currencies->name,
            'status' => $this->statuses,
            'responsible' => $this->responsible ?? 'Не выбран.',
        ];
    }

    /**
     * @return array
     */
    protected function payments(): array
    {
        $payments = [];
        foreach ($this->payments as $payment) {
            array_push( $payments, [
                'id' => $payment->id,
                'label' => implode(' ', [
                    'country' => $payment->country->name,
                    'type' => $payment->type->title,
                    'sum' => $payment->sum . ' ' . $payment->currency,
                    'status' => $payment->statuses,
                    'date' => $payment->created_at->format('d.m.Y'),
                ]),
                'children' => json_decode($payment->histories)
            ]);
        }
        return $payments;
    }
}
