<?php

namespace App\Http\Controllers;

use App\Models\Bks;
use App\Models\Pivot\Bets;
use App\Models\Pivot\Countries;
use Inertia\Inertia;

class BkController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Bk', [
            'countries' => Countries::all(),
            'statuses' => Bks::STATUSES,
            'bets' => Bets::all()
        ]);
    }

    /**
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        return Inertia::render('Bk/BkShow', [
            'id' => 'qweqweqw'
        ]);
    }
}
