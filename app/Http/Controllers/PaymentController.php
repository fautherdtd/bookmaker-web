<?php

namespace App\Http\Controllers;

use App\Models\Bks;
use App\Models\Payments;
use App\Resources\BK\BksResources;
use App\Resources\Payments\PaymentResources;
use App\Resources\Payments\PaymentsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    /**
     * @return Response
     */
    public function index(Request $request): Response
    {
        $builder = Payments::with(['country', 'type'])
            ->whereHas('bk', function($query){
                $query->where('responsible', Auth::id());
            });

        foreach ($request->all() as $key => $value) {
            if ($request->has($key)) {
                $builder->where($key, $value);
            }
        }
        return Inertia::render('Payments', [
            'data' => new PaymentsResources($builder->get()),
            'pivot' => [
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
     * @return Response
     */
    public function create(): Response
    {
        $builder = Bks::with(['country', 'bet']);
        if (! Auth::user()->hasRole(['administrator'])) {
            $builder->where('responsible', Auth::id());
        }
        return Inertia::render('Payment/Create', [
            'pivot' => [
                'type' => $this->pivots()->typePayments(),
                'status' => Payments::STATUSES,
                'currencies' => $this->pivots()->currencies(),
                'countries' => $this->pivots()->countries(),
                'bk' => new BksResources($builder->get())
            ]
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'bk.code' => ['required', 'exists:App\Models\Bks,id'],
            'type_id.code' => ['required', 'exists:App\Models\Pivot\PaymentTypes,id'],
            'sum' => ['required', 'int'],
            'currency.code' => ['required', 'exists:App\Models\Pivot\Currencies,code'],
            'status.code' => ['required', Rule::in(['active', 'block'])],
        ])->validateWithBag('storePayment');
        $bk = Bks::find((int) $request->input('bk.code'));
        Payments::create([
            'type_id' => $request->input('type_id.code'),
            'bk_id' => $request->input('bk.code'),
            'sum' => $request->input('sum'),
            'currency' => $request->input('currency.code'),
            'status' => $request->input('status.code'),
            'drop' => $bk->drop,
            'country_id' => $bk->country_id,
        ]);
        return response()->json('Success');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            Payments::whereId( $id)
                ->update($request->all());
            return response()->json('Сохранен.');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }

    }
}

