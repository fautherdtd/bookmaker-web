<?php

namespace App\Models;

use App\Models\Pivot\Countries;
use App\Models\Pivot\Currencies;
use App\Models\Pivot\PaymentTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payments extends Model
{
    use HasFactory;
    const STATUSES = [
        'block' => 'Заблокирован',
        'active' => 'Активен'
    ];

    protected $fillable = [
        'type_id',
        'sum',
        'currency',
        'status',
        'bk_id',
        'country_id',
        'drop',
        'external'
    ];

    /**
     * @return string
     */
    public function getStatusesAttribute(): string
    {
        return $this::STATUSES[$this->status];
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
    public function type(): HasOne
    {
        return $this->hasOne(PaymentTypes::class, 'id', 'country_id');
    }

    /**
     * @return HasOne
     */
    public function currencies(): HasOne
    {
        return $this->hasOne(Currencies::class, 'code', 'currency');
    }

    /**
     * @return HasOne
     */
    public function bk(): HasOne
    {
        return $this->hasOne(Bks::class, 'id', 'bk_id');
    }
}
