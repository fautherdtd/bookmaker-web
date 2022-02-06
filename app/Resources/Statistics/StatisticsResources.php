<?php

namespace App\Resources\Statistics;

use App\Models\Bks;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResources extends JsonResource
{
    public function toArray($request)
    {
        foreach (Bks::STATUSES as $key=>$value) {
            if(! $this->resource->contains('status', $key) && $key !== 'new') {
                $this->resource->push((object) [
                    'status' => $key,
                    'count' => 0,
                    'cash' => 0
                ]);
            }
        }
        return StatisticResources::collection($this->resource);
    }
}
