<?php

namespace App\Http\Controllers;

use App\Models\Bks;
use App\Models\Statistics as StatisticsModel;
use App\Resources\Statistics\StatisticsResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $builder = StatisticsModel::where('responsible', Auth::id())
            ->get();
        $statusCount = Bks::where('responsible', Auth::id())
                ->groupBy('status')
                ->select('status', DB::raw('count(*) as total'))
                ->get();
        $resources = $builder->merge($statusCount);
        return Inertia::render('Statistics', [
            'data' => [
//                'statistics' => new StatisticsResources($resources),
//                'count' => $statusCount
            ]
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
        $model = new StatisticsModel();
    }
}
