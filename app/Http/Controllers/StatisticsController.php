<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use function Symfony\Component\Translation\t;

class StatisticsController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Statistics');
    }

    /**
     * @return \Inertia\Response
     */
    public function dashboard(): \Inertia\Response
    {
        $this->handler();
        return Inertia::render('Dashboard');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handler()
    {
        if (!Auth::user()->hasRole('administrator')) {
            return redirect()->route('statistics.index');
        }
        return redirect()->route('statistics.dashboard');
    }
}
