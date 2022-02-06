<?php

namespace App\Resources\Statistics\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardCommonResources extends JsonResource
{
    public function toArray($request)
    {
        return $this->resource->first();
    }
}
