<?php

namespace App\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResources extends JsonResource
{
    public function toArray($request)
    {
        return new StatisticResources($this->resource);
    }
}
