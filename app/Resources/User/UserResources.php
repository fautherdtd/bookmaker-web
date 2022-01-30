<?php

namespace App\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'roles' => implode(', ', $this->getRoleNames()->each(function ($item) {
                return config('bookmaker.roles-ru' . $item);
            })->toArray())
        ];
    }
}
