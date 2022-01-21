<?php

namespace App\Http\Controllers;

use App\Models\Pivot\Bets;
use App\Models\Pivot\Countries;
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
}
