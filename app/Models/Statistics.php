<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Statistics extends Model
{
    protected $table = 'statistics';

    protected $fillable = [
        'bk_wait',
        'bk_on_verification',
        'bk_on_withdrawn',
        'bk_withdrawn',
        'bk_preparing_documents',
        'bk_waiting_drop',
        'bk_trouble',
        'bk_debiting',
        'responsible',
        'created_at',
        'updated_at'
    ];

    /**
     * @return HasOne
     */
    public function userResponsible(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'responsible');
    }
}
