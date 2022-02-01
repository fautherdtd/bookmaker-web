<?php

namespace App\Http\Controllers;

use App\Models\Bks;
use App\Models\Pivot\Bets;
use App\Models\Pivot\Countries;
use App\Models\Pivot\Currencies;
use App\Models\Pivot\PaymentTypes;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PivotEntityController extends Controller
{

    /**
     * @return mixed
     */
    public function countries()
    {
        return Cache::remember('countries:all', 3600, function () {
           return Countries::all();
        });
    }

    /**
     * @return mixed
     */
    public function bets()
    {
        return Cache::remember('bets:all', 3600, function () {
           return Bets::all();
        });
    }

    /**
     * @return mixed
     */
    public function drops()
    {
        return Cache::remember('drop:all', 360, function () {
           return Bks::pluck('drop');
        });
    }

    /**
     * @return mixed
     */
    public function dropGuides()
    {
        return Cache::remember('dropGuides:all', 360, function () {
           return Bks::pluck('drop_guide');
        });
    }

    /**
     * @return mixed
     */
    public function typePayments()
    {
        return Cache::remember('typePayments:all', 3600, function () {
           return PaymentTypes::all();
        });
    }

    /**
     * @return mixed
     */
    public function currencies()
    {
        return Cache::remember('currencies:all', 3600, function () {
           return Currencies::all();
        });
    }

    /**
     * @return mixed
     */
    public function responsible()
    {
        return Cache::remember('User:all', 3600, function () {
           return User::all();
        });
    }
}
