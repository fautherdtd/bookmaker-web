<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
