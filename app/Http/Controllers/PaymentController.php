<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Resources\Payments\PaymentResources;
use App\Resources\Payments\PaymentsResources;
use Illuminate\Http\Request;
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
            'data' => new PaymentsResources($builder),
            'filter' => [
                'countries' => $this->pivots()->countries(),
                'drops' => $this->pivots()->drops(),
                'type' => $this->pivots()->typePayments(),
                'status' => Payments::STATUSES,
            ]
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

    /**
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $builder = Payments::with(['country', 'type', 'bk', 'bk.bet'])
            ->where('id', $id)
            ->first();
        return Inertia::render('Payment/Edit', [
            'item' => new PaymentResources($builder),
            'pivot' => [
                'type' => $this->pivots()->typePayments(),
                'status' => Payments::STATUSES,
                'currencies' => $this->pivots()->currencies()
            ]
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $model = Payments::whereId( $id)
                ->update($request->all());
            return response()->json('Сохранен.');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

    }
}

