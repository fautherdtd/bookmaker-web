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
        $statistics = DB::table('statistics')
            ->select(
                'status',
                DB::raw('(SELECT SUM(cash) FROM statistics as b WHERE b.status = statistics.status) as cash'),
                DB::raw('(SELECT count(status) FROM statistics as c WHERE c.status = statistics.status) as count'),
            )
            ->where('responsible', Auth::id())
            ->whereMonth('created_at', $this->carbonMonth($request))
            ->whereYear('created_at', $this->carbonYear($request))
            ->groupBy('status')
            ->get();
        $common = DB::table('statistics')
            ->select(DB::raw('sum(cash) as cash, count(id) as count'))
            ->where('responsible', Auth::id())
            ->whereMonth('created_at', $this->carbonMonth($request))
            ->whereYear('created_at', $this->carbonYear($request))
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

        return DB::table('statistics')
            ->leftJoin('users', 'users.id', '=', 'statistics.responsible')
            ->select(
                DB::raw('count(statistics.id) as handed'),
                DB::raw('sum(statistics.cash) as cash'),
                DB::raw('COUNT((SELECT statistics.status FROM statistics as stat WHERE stat.status = \'withdrawn\' AND stat.responsible = statistics.responsible)) as withdrawn'),
                DB::raw('SUM((SELECT cash FROM statistics as stat WHERE stat.status = \'withdrawn\' AND stat.responsible = statistics.responsible)) as withdrawnCash'),
                DB::raw('users.name'),
            )
            ->whereMonth('statistics.created_at', $month)
            ->whereYear('statistics.created_at', $year)
            ->groupBy('users.name')
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
            DB::table('statistics as s')
            ->select(
                DB::raw('count(s.id) as handed'),
                DB::raw('sum(s.cash) as cash'),
                DB::raw('count(s.id) filter ( where s.status = \'withdrawn\') as withdrawn'),
                DB::raw('sum(s.cash) filter ( where s.status = \'withdrawn\') as withdrawncash'),
            )
            ->whereMonth('s.created_at', $month)
            ->whereYear('s.created_at', $year)
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
                ->select(
                    DB::raw('sum(sum) as all'),
                    DB::raw('sum(sum) filter (where status = \'active\') as active'),
                    DB::raw('sum(sum) filter (where status = \'trouble\') as block'),
                    DB::raw('sum(sum) filter (where status = \'withdrawn\') as withdrawn')
                )
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get(),
            'count' => DB::table('bks')
                ->select(
                    DB::raw('count(id)'),
                    DB::raw('count(id) filter ( where status = \'active\') as active'),
                    DB::raw('count(id) filter ( where status = \'trouble\') as block'),
                    DB::raw('count(id) filter ( where status = \'withdrawn\') as withdrawn')
                )
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get()
        ];
    }

    /**
     * @param int $bkID
     * @return bool
     */
    public function create(int $bkID): bool
    {
        $bk = Bks::find($bkID);
        $model = new StatisticsModel;
        $model->responsible = $bk->responsible;
        $model->status = $bk->status;
        $model->bk_id = $bkID;
        $model->cash = $this->converterCurrency($bk->currency, $bk->sum);
        return $model->save();
    }

    /**
     * @param int $bkID
     * @return bool
     */
    public function update(int $bkID): bool
    {
        $bk = Bks::find($bkID);
        $model = StatisticsModel::where([
            ['bk_id', $bkID],
            ['responsible', $bk->responsible]
        ])->first();
        $model->responsible = $bk->responsible;
        $model->status = $bk->status;
        $model->bk_id = $bkID;
        $model->cash = $this->converterCurrency($bk->currency, $bk->sum);
        return $model->save();
    }
}
