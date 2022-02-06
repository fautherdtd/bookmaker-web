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
            'responsible' => DB::table('statistics')
                ->leftJoin('users', 'users.id', '=', 'statistics.responsible')
                ->select(
                    DB::raw('count(statistics.id) as handed'),
                    DB::raw('sum(statistics.cash) as cash'),
                    DB::raw('COUNT((SELECT statistics.status FROM statistics as stat WHERE stat.status = \'withdrawn\' AND stat.responsible = statistics.responsible)) as withdrawn'),
                    DB::raw('SUM((SELECT cash FROM statistics as stat WHERE stat.status = \'withdrawn\' AND stat.responsible = statistics.responsible)) as withdrawnCash'),
                    DB::raw('users.name'),
                )
                ->whereMonth('statistics.created_at', $this->carbonMonth($request))
                ->whereYear('statistics.created_at', $this->carbonYear($request))
                ->groupBy('users.name')
                ->get(),
            'common' => new DashboardCommonResources(DB::table('statistics as s')
                ->select(
                    DB::raw('count(s.id) as handed'),
                    DB::raw('sum(s.cash) as cash'),
                    DB::raw('(SELECT count(s.id) FROM statistics WHERE statistics.status = \'withdrawn\') as withdrawn'),
                    DB::raw('(SELECT sum(s.cash) FROM statistics WHERE statistics.status = \'withdrawn\') as withdrawncash'),
                )
                ->whereMonth('s.created_at', $this->carbonMonth($request))
                ->whereYear('s.created_at', $this->carbonYear($request))
                ->get())
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function commonDashboardStatistics(Request $request): array
    {
        return [
            'cash' => DB::table('statistics')
                ->select(
                    DB::raw('sum(cash) as all'),
                    DB::raw('(SELECT sum(cash) FROM statistics WHERE status = \'active\') as active'),
                    DB::raw('(SELECT sum(cash) FROM statistics WHERE status = \'block\') as block'),
                    DB::raw('(SELECT sum(cash) FROM statistics WHERE status = \'withdrawn\') as withdrawn')
                )
                ->whereMonth('created_at', $this->carbonMonth($request))
                ->whereYear('created_at', $this->carbonYear($request))
                ->get(),
            'count' => DB::table('bks')
                ->select(
                    DB::raw('count(id)'),
                    DB::raw('count(id) filter ( where status = \'active\') as active'),
                    DB::raw('count(id) filter ( where status = \'trouble\') as block'),
                    DB::raw('count(id) filter ( where status = \'withdrawn\') as withdrawn')
                )
                ->whereMonth('created_at', $this->carbonMonth($request))
                ->whereYear('created_at', $this->carbonYear($request))
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
