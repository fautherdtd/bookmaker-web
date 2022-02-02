<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Statistics extends Model
{
    protected $table = 'statistics';

    protected $fillable = [
        'status',
        'cash',
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
