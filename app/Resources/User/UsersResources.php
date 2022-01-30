<?php

namespace App\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\JsonSerializable
     */
    public function toArray($request)
    {
        return UserResources::collection($this->resource);
    }
}
