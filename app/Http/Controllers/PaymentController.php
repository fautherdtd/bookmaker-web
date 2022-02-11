<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\Helpers;
use App\Models\Bks;
use App\Models\Payments;
use App\Resources\BK\BksResources;
use App\Resources\Payments\PaymentResources;
use App\Resources\Payments\PaymentsResources;
use App\Services\CurrencyConverter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $builder = Payments::with(['country', 'type'])
            ->whereHas('bk', function($query){
                $query->where('status', '!=', 'new');
            });
        if (! Auth::user()->hasRole(['administrator'])) {
            $builder->whereHas('bk', function($query){
                $query->where('responsible', Auth::id());
            });
        }

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
     * @return RedirectResponse|Response
     */
    public function edit(int $id)
    {
        $builder = Payments::with(['country', 'type', 'bk', 'bk.bet'])
            ->where('id', $id)
            ->first();
        if ($builder->external) {
            return redirect()->back();
        }
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
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'bk' => ['required', 'exists:App\Models\Bks,id'],
            'type_id' => ['required', 'exists:App\Models\Pivot\PaymentTypes,id'],
            'sum' => ['required', 'int'],
            'currency' => ['required', 'exists:App\Models\Pivot\Currencies,code'],
            'status' => ['required', Rule::in(['active', 'block'])],
        ])->validateWithBag('storePayment');
        $bk = Bks::find((int) $request->input('bk'));
        Payments::create([
            'type_id' => $request->input('type_id'),
            'bk_id' => $request->input('bk'),
            'sum' => $request->input('sum'),
            'currency' => $request->input('currency'),
            'status' => $request->input('status'),
            'drop' => $bk->drop,
            'external' => false,
            'country_id' => $bk->country_id,
        ]);
        return redirect()->back();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        try {
            Payments::whereId($id)
                ->update($request->all());
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    /**
     * @param int $id
     * @param int $sum
     * @param string $currency
     * @return bool
     */
    public function incrementSum(int $id, int $sum, string $currency): bool
    {
        $model = Payments::find($id);
        $value = (new CurrencyConverter($sum, ['main' => $model->currency, 'sub' => $currency]))->converter();
        $model->sum = $model->sum + intval($value);
        return $model->save();
    }
}

