<?php

namespace App\Resources\Statistics;

use App\Models\Bks;
use Illuminate\Http\Resources\Json\JsonResource;


class StatisticResources extends JsonResource
{
    public function toArray($request)
    {
        return implode(' ', [
            'status' => '"' .Bks::STATUSES[$this->status] . '"',
            'count' => $this->count,
            'cash' => 'на сумму ' . $this->cash
        ]);
    }
}
