<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class StatisticsController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Statistics');
    }
}
