<?php

namespace App\Resources\BK;

use Illuminate\Http\Resources\Json\JsonResource;

class BksResources extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\JsonSerializable
     */
    public function toArray($request)
    {
        return BkResources::collection($this->resource);
    }
}
