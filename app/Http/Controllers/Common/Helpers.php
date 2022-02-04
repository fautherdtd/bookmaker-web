<?php

namespace App\Http\Controllers\Common;

use App\Models\Pivot\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

trait Helpers
{

    /**
     * @param string $currency
     * @param $sum
     * @return float
     */
    public function converterCurrency(string $currency, $sum): float
    {
        $currency = Currencies::where('code', $currency)->first();
        return floatval($sum / floatval($currency->exchange));
    }

    /**
     * @param Request $request
     * @return false|Carbon|int
     */
    public function carbonMonth(Request $request)
    {
        return $request->has('month') ?
            Carbon::create()->day(1)->month(
                (int) $request->input('month')
            ) : Carbon::now()->month;
    }

    /**
     * @param Request $request
     * @return false|Carbon|int
     */
    public function carbonYear(Request $request)
    {
        return $request->has('year') ?
            Carbon::create()->day(1)->year(
                (int) $request->input('year')
            ) : Carbon::now()->year;
    }
}
