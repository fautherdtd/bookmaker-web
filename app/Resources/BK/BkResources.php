<?php

namespace App\Resources\BK;

use Illuminate\Http\Resources\Json\JsonResource;

class BkResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'drop' => $this->drop,
            'cash' => $this->cash,
            'bk' => $this->bet->name,
            'drop_guide' => $this->drop_guide,
            'status' => $this->statuses,
        ];
    }
}
