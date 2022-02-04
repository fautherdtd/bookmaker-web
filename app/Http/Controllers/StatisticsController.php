<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\Helpers;
use App\Models\Bks;
use App\Models\Pivot\Currencies;
use App\Models\Statistics;
use App\Models\Statistics as StatisticsModel;
use App\Resources\Statistics\Responsible\StatisticsCommonResources;
use App\Resources\Statistics\StatisticsResources;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    use Helpers;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(\Illuminate\Http\Request $request): \Inertia\Response
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
     * @return \Inertia\Response
     */
    public function dashboard(): \Inertia\Response
    {
        return Inertia::render('Dashboard');
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
