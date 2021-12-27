<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BkController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Bk');
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
