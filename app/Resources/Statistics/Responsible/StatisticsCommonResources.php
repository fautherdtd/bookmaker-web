<?php

namespace App\Resources\Statistics\Responsible;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsCommonResources extends JsonResource
{
    public function toArray($request)
    {
        $values = $this->resource->first();
        return [
            'count' => $values->count ?? 0,
            'cash' => $values->cash ?? 0,
        ];
    }
}
