<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\Helpers;
use App\Models\Bks;
use App\Models\Pivot\Currencies;
use App\Models\Statistics;
use App\Models\Statistics as StatisticsModel;
use App\Resources\Statistics\Dashboard\DashboardCommonResources;
use App\Resources\Statistics\Responsible\StatisticsCommonResources;
use App\Resources\Statistics\StatisticsResources;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    use Helpers;

    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function index(\Illuminate\Http\Request $request): Response
    {
        $statistics = DB::table('bks as bk')
            ->join('currencies as c', 'bk.currency', '=', 'c.code')
            ->select(
                DB::raw('bk.status'),
                DB::raw('count(bk.id) as handed'),
                DB::raw('sum(CASE WHEN currency != \'EUR\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' THEN sum END) as cash'),
                DB::raw('count(bk.status)'),
            )
            ->where('bk.responsible', Auth::id())
            ->whereMonth('bk.created_at', $this->carbonMonth($request))
            ->whereYear('bk.created_at', $this->carbonYear($request))
            ->groupBy('bk.status')
            ->get();
        $common = DB::table('bks as bk')
            ->join('currencies as c', 'bk.currency', '=', 'c.code')
            ->select(
                DB::raw('count(bk.id) as count'),
                DB::raw('sum(CASE WHEN bk.currency != \'EUR\' THEN floor(bk.sum / c.exchange) WHEN bk.currency = \'EUR\' THEN bk.sum END) as cash')
            )
            ->where('bk.responsible', Auth::id())
            ->whereMonth('bk.created_at', $this->carbonMonth($request))
            ->whereYear('bk.created_at', $this->carbonYear($request))
            ->get();
        return Inertia::render('Statistics', [
            'statistics' => new StatisticsResources($statistics),
            'common' => new StatisticsCommonResources($common)
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function dashboard(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'common' => [
                'cash' => $this->commonDashboardStatistics($request)['cash']->first(),
                'count' => $this->commonDashboardStatistics($request)['count']->first()
            ],
            'detailed' => $this->detailedSummaryDashboardStatistics($request)
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function detailedSummaryDashboardStatistics(Request $request): array
    {
        return [
            'responsible' => $this->detailedSummaryDashboardStatisticsResponsible($request),
            'common' => $this->detailedSummaryDashboardStatisticsCommon($request),
        ];
    }

    /**
     * @param Request $request
     * @return Collection
     */
    protected function detailedSummaryDashboardStatisticsResponsible(Request $request): Collection
    {
        $month = $request->has('responsible.month') ?
            Carbon::create()->day(1)->month(
                (int) $request->input('responsible.month')
            ) : Carbon::now()->month;
        $year = $request->has('responsible.year') ?
            Carbon::create()->day(1)->year(
                (int) $request->input('responsible.year')
            ) : Carbon::now()->year;

        return DB::table('bks as bk')
            ->join('users as u', 'u.id', '=', 'bk.responsible')
            ->join('currencies as c', 'bk.currency', '=', 'c.code')
            ->select(
                DB::raw('u.name'),
                DB::raw('count(bk.id) as handed'),
                DB::raw('sum(CASE WHEN currency != \'EUR\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' THEN sum END) as cash'),
                DB::raw('count(bk.id) filter ( where status = \'withdrawn\' ) as withdrawn'),
                DB::raw('sum(CASE
                    WHEN currency != \'EUR\' AND status = \'withdrawn\' THEN floor(sum_trans / c.exchange)
                    WHEN currency = \'EUR\' AND status = \'withdrawn\' THEN sum_trans END
                ) as withdrawnCash'),
            )
            ->whereMonth('bk.created_at', $month)
            ->whereYear('bk.created_at', $year)
            ->groupBy('u.name')
            ->get();
    }

    /**
     * @param Request $request
     * @return DashboardCommonResources
     */
    protected function detailedSummaryDashboardStatisticsCommon(Request $request): DashboardCommonResources
    {
        $month = $request->has('responsible.month') ?
            Carbon::create()->day(1)->month(
                (int) $request->input('responsible.month')
            ) : Carbon::now()->month;
        $year = $request->has('responsible.year') ?
            Carbon::create()->day(1)->year(
                (int) $request->input('responsible.year')
            ) : Carbon::now()->year;
        return new DashboardCommonResources(
            DB::table('bks as bk')
                ->join('currencies as c', 'bk.currency', '=', 'c.code')
                ->select(
                    DB::raw('count(bk.id) as handed'),
                    DB::raw('sum(CASE WHEN currency != \'EUR\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' THEN sum END) as cash'),
                    DB::raw('count(bk.id) filter ( where bk.status = \'withdrawn\' ) as withdrawn'),
                    DB::raw('sum(CASE WHEN currency != \'EUR\' AND status = \'withdrawn\' THEN floor(sum_trans / c.exchange) WHEN currency = \'EUR\' AND status = \'withdrawn\' THEN floor(sum_trans) END) as withdrawnCash'),
                )
                ->whereMonth('bk.created_at', $month)
                ->whereYear('bk.created_at', $year)
                ->get());
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function commonDashboardStatistics(Request $request): array
    {
        $month = $request->filled('common.month') ?
            Carbon::create()->day(1)->month(
                (int) $request->input('common.month')
            ) : Carbon::now()->month;
        $year = $request->filled('common.year') ?
            Carbon::create()->day(1)->year(
                (int) $request->input('common.year')
            ) : Carbon::now()->year;
        return [
            'cash' => DB::table('bks')
                ->join('currencies as c', 'bks.currency', '=', 'c.code')
                ->select(
                    DB::raw('sum(CASE WHEN currency != \'EUR\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' THEN sum END) as all'),
                    DB::raw('sum(CASE WHEN currency != \'EUR\' AND status = \'active\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' AND status = \'active\' THEN floor(sum) END) as active'),
                    DB::raw('sum(CASE WHEN currency != \'EUR\' AND status = \'trouble\' THEN floor(sum / c.exchange) WHEN currency = \'EUR\' AND status = \'trouble\' THEN floor(sum) END) as trouble'),
                    DB::raw('sum(CASE WHEN currency != \'EUR\' AND status = \'withdrawn\' THEN floor(sum_trans / c.exchange) WHEN currency = \'EUR\' AND status = \'withdrawn\' THEN floor(sum_trans) END) as withdrawn')
                )
                ->whereMonth('bks.created_at', $month)
                ->whereYear('bks.created_at', $year)
                ->get(),
            'count' => DB::table('bks')
                ->select(
                    DB::raw('count(id)'),
                    DB::raw('count(id) filter ( where status = \'active\') as active'),
                    DB::raw('count(id) filter ( where status = \'trouble\') as trouble'),
                    DB::raw('count(id) filter ( where status = \'withdrawn\') as withdrawn')
                )
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get()
        ];
    }
}
