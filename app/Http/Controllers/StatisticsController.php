<?php

namespace App\Http\Controllers;

use App\Models\Bks;
use App\Models\Pivot\Currencies;
use App\Models\Statistics as StatisticsModel;
use App\Resources\Statistics\Responsible\StatisticsCommonResources;
use App\Resources\Statistics\StatisticsResources;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(\Illuminate\Http\Request $request): \Inertia\Response
    {
        $month = $request->has('month') ?
            Carbon::create()->day(1)->month(
                (int) $request->input('month')
            ) : Carbon::now()->month;
        $year = $request->has('year') ?
            Carbon::create()->day(1)->year(
                (int) $request->input('year')
            ) : Carbon::now()->year;
        $statistics = DB::table('statistics')
            ->select(
                'status',
                DB::raw('(SELECT SUM(cash) FROM statistics as b WHERE b.status = statistics.status) as cash'),
                DB::raw('(SELECT count(status) FROM statistics as c WHERE c.status = statistics.status) as count'),
            )
            ->where('responsible', Auth::id())
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('status')
            ->get();
        $common = DB::table('statistics')
            ->select(DB::raw('sum(cash) as cash, count(id) as count'))
            ->where('responsible', Auth::id())
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        return Inertia::render('Statistics', [
            'statistics' => new StatisticsResources($statistics),
            'common' => new StatisticsCommonResources($common)
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function dashboard(): \Inertia\Response
    {
        return Inertia::render('Dashboard');
    }

    /**
     *
     */
    public function create(int $bkID)
    {
        $bk = Bks::find($bkID);
        $currency = Currencies::where('code', $bk->currency)->first();
        StatisticsModel::create([
            'responsible' => $bk->responsible,
            'status' => $bk->status,
            'cash' => floatval($bk->sum / floatval($currency->exchange))
        ]);
    }
}
