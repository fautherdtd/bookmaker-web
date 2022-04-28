<?php

namespace App\Resources\BK;

use App\Models\User;
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

            'sum' => $this->sum,
            'cash' => $this->cash,
            'currencies' => $this->currencies->name,

            'status' => [
                'key' => $this->status,
                'value' => $this->statuses,
            ],
            'touch_updated' => $this->touch_updated_at,
            'responsible' => [
                'id' => $this->responsible,
                'name' => $this->userResponsible->name
            ],
            'stories' => $this->formatStories()
        ];
    }

    /**
     * @return array
     */
    protected function payments(): array
    {
        $payments = [];
        foreach ($this->payments as $payment) {
            $payments[] = [
                'id' => $payment->id,
                'label' => implode(' ', [
                    'country' => $payment->country->name,
                    'type' => $payment->type->title,
                    'sum' => $payment->sum . ' ' . $payment->currency,
                    'status' => $payment->statuses,
                    'date' => $payment->created_at->format('d.m.Y'),
                ]),
                'children' => json_decode($payment->histories)
            ];
        }
        return $payments;
    }

    /**
     * @return array
     */
    protected function formatStories(): array
    {
        $stories = [];
        foreach ($this->stories as $story) {
            $stories[] = implode(' - ', [
                $story->created_at->format('d.m.Y H:s'),
                $story->user,
                $story->action
            ]);
        }
        return $stories;
    }
}
