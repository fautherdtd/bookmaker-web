<?php

namespace App\Services;

use App\Models\Pivot\Currencies;

class CurrencyConverter
{
    public int $value;
    public array $currencies;

    /**
     * @param int $cash
     * @param array $currencies
     */
    public function __construct(
        int $cash,
        array $currencies
    )
    {
        $this->value = $cash;
        $this->currencies = $currencies;
    }

    /**
     * @return float
     */
    protected function getCurrencyValue(): float
    {
        return floatval(Currencies::where('code', $this->currencies['main'])->pluck('exchange')->first());
    }

    /**
     * @return float
     */
    protected function getCurrencySub(): float
    {
        return floatval(Currencies::where('code', $this->currencies['sub'])->pluck('exchange')->first());
    }
    /**
     * @return float
     */
    protected function getMainCurrencyValue(): float
    {
        return floatval($this->value / $this->getCurrencySub());
    }

    /**
     * @return float
     */
    public function converter(): float
    {
        return floatval($this->getCurrencyValue() * $this->getMainCurrencyValue());
    }

    /**
     * @return float
     */
    public function converterCommon(): float
    {
        return floatval($this->value / $this->getCurrencyValue());
    }
}
