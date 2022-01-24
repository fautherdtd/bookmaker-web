<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Model;

class BkStories extends Model
{
    protected $table = 'bk_stories';

    protected $fillable = [
        'bk_id',
        'action',
        'user'
    ];
}
