<?php

namespace App\Http\Controllers;

use App\Models\Bks as BkModel;
use App\Resources\BK\BkItemResources;
use App\Resources\BK\BksResources;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BkController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name']);
        return Inertia::render('Bk', [
            'data' => new BksResources($builder->get()),
            'countries' => $this->pivots()->countries(),
            'statuses' => BkModel::STATUSES,
            'bets' => $this->pivots()->bets()
        ]);
    }

    /**
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'currencies:id,code,name', 'payments'])
            ->where('id', $id)
            ->first();
        return Inertia::render('Bk/Show', [
            'item' => new BkItemResources($builder)
        ]);
    }

    /**
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'currencies:id,code,name', 'payments'])
            ->where('id', $id)
            ->first();
        return Inertia::render('Bk/Edit', [
            'item' => new BkItemResources($builder),
            'statuses' => BkModel::STATUSES,
        ]);
    }
}
