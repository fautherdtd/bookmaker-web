<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Resources\Payments\PaymentResources;
use App\Resources\Payments\PaymentsResources;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $builder = Payments::with(['country', 'type'])
            ->get();
        return Inertia::render('Payments', [
            'data' => new PaymentsResources($builder)
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $builder = Payments::with(['country', 'type', 'bk', 'bk.bet'])
            ->where('id', $id)
            ->first();
        return Inertia::render('Payment/Show', [
            'item' => new PaymentResources($builder)
        ]);
    }
}

