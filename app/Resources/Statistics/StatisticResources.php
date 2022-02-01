<?php

namespace App\Resources\Statistics;

use App\Models\Bks;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'bk_wait' => $this->bk_wait,
            'bk_on_verification' => $this->bk_wait,
            'bk_on_withdrawn' => $this->bk_wait,
            'bk_withdrawn' => $this->bk_wait,
            'bk_preparing_documents' => $this->bk_wait,
            'bk_waiting_drop' => $this->bk_wait,
            'bk_trouble' => $this->bk_wait,
            'bk_debiting' => $this->bk_wait,
            'responsible' => $this->bk_wait,
        ];
    }
}
