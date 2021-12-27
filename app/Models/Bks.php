<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bks extends Model
{
    use HasFactory;

    const STATUSES = [
        'waiting' => 'Ожидание',
        'on_verification' => 'На верификации',
        'on_withdrawn' => 'На выводе',
        'withdrawn' => 'Выведен',
        'preparing_documents' => 'Готовим документы',
        'waiting_drop' => 'Ожидание дропа',
        'trouble' => 'Проблемный',
        'debiting' => 'На списание',
    ];
}
