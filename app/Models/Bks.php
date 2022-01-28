<?php

namespace App\Models;

use App\Models\Pivot\Bets;
use App\Models\Pivot\BkStories;
use App\Models\Pivot\Countries;
use App\Models\Pivot\Currencies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bks extends Model
{
    use HasFactory;

    const STATUSES = [
        'waiting' => 'Ожидание',
        'on_verification' => 'На верификации',
        'on_withdrawn' => 'На выводе',
        'in_work' => 'В работе',
        'withdrawn' => 'Выведен',
        'preparing_documents' => 'Готовим документы',
        'waiting_drop' => 'Ожидание дропа',
        'trouble' => 'Проблемный',
        'debiting' => 'На списание',
    ];

    /**
     * @return string
     */
    public function getStatusesAttribute(): string
    {
        return $this::STATUSES[$this->status];
    }

    /**
     * @return string
     */
    public function getCashAttribute(): string
    {
        return $this->sum . ' ' . $this->currency;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Bets::class, 'id', 'bet_id');
    }

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

    /**
     * @return HasOne
     */
    public function currencies(): HasOne
    {
        return $this->hasOne(Currencies::class, 'code', 'currency');
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payments::class, 'bk_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function stories(): HasMany
    {
        return $this->hasMany(BkStories::class, 'bk_id', 'id');
    }
}
