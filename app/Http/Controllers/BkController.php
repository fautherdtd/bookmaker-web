<?php

namespace App\Http\Controllers;

use App\Http\Controllers\StatisticsController;
use App\Models\Bks as BkModel;
use App\Models\Payments;
use App\Models\Pivot\BkStories;
use App\Models\User;
use App\Resources\BK\BkItemResources;
use App\Resources\BK\BksResources;
use App\Resources\Payments\PaymentResources;
use App\Resources\Payments\Selects\PaymentSelectResources;
use App\Resources\Payments\Selects\PaymentSelectsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BkController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'userResponsible:id,name'])
            ->where([
                ['status', '!=', 'new'],
                ['responsible', '!=', null]
            ]);
        if (! Auth::user()->hasRole(['administrator'])) {
            $builder->where('responsible', Auth::id());
        }

        if($request->has('withdrawn')) {
            $builder->where('status', '!=', 'withdrawn');
        }
        foreach ($request->all() as $key => $value) {
            if ($request->has($key) && !$request->input('withdrawn')) {
                $builder->where($key, $value);
            }
        }

        return Inertia::render('Bk', [
            'data' => new BksResources($builder->get()),
            'pivot' => [
                'countries' => $this->pivots()->countries(),
                'status' => BkModel::STATUSES,
                'bets' => $this->pivots()->bets(),
                'drops' => $this->pivots()->drops(),
                'responsible' => $this->pivots()->responsible(),
                'dropGuides' => $this->pivots()->dropGuides(),
            ],
            'payload' => [
                'distributions' => BkModel::where('responsible', null)->get()->count('id')
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function distribution(Request $request): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'userResponsible'])
            ->where('status', 'new');

        foreach ($request->all() as $key => $value) {
            if ($request->has($key)) {
                $builder->where($key, $value);
            }
        }
        return Inertia::render('Bk/Distribution', [
            'data' => new BksResources($builder->get()),
            'pivot' => [
                'countries' => $this->pivots()->countries(),
                'bets' => $this->pivots()->bets(),
                'drops' => $this->pivots()->drops(),
                'dropGuides' => $this->pivots()->dropGuides(),
                'responsible' => User::all()
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function distributionSave(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        BkModel::where('id', (int) $request->input('id'))
            ->update([
                'responsible' => (int) $request->input('responsible'),
                'status' => 'waiting'
            ]);
        if (! (new StatisticsController())->create($request->input('id'))) {
            DB::rollBack();
            return redirect()->back();
        }
        DB::commit();
        return redirect()->back();
    }

    /**
     * @param int $id
     * @return \Inertia\Response
     */
    public function show(int $id): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'currencies:id,code,name', 'payments', 'stories'])
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
        $payments = Payments::with(['country', 'type', 'bk'])
            ->where('status', '!=', 'block');
        if (! Auth::user()->hasRole(['administrator'])) {
            $payments->whereHas('bk', function($query){
                $query->where('responsible', Auth::id());
            });
        }
        return Inertia::render('Bk/Edit', [
            'item' => new BkItemResources($builder),
            'statuses' => BkModel::STATUSES,
            'responsible' => User::all(),
            'payments' => new PaymentSelectsResources($payments->get())
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(int $id, Request $request)
    {
        $model = BkModel::find($id);
        $actions = [];
        if ($request->input('email') != $model->email) {
            $actions[] = ['Логин почты изменен с "' . $model->email . '" на "' . $request->input('email') . '"'];
            $model->email = $request->input('email');
        }
        if ($request->input('password') != $model->password) {
            $actions[] = ['Пароль почты изменен с "' . $model->password . '" на "' . $request->input('password') . '"'];
            $model->email = $request->input('password');
        }
        if ($request->input('info') != $model->info) {
            $actions[] = ['Доп.информация изменена с "' . $model->info . '" на "' . $request->input('info') . '"'];
            $model->info = $request->input('info');
        }
        if ($request->input('sum') != $model->sum) {
            $actions[] = ['Сумма изменена с "' . $model->sum . '" на "' . $request->input('sum') . '"'];
            $model->sum = $request->input('sum');
        }
        if ($request->input('status') != $model->status) {
            $actions[] = ['Статус изменен с "' . $model->statuses . '" на "' . BkModel::STATUSES[$request->input('status')] . '"'];
            $model->status = $request->input('status');
        }
        if ($request->filled('comment')) {
            $actions[] = ['Добавлен комментарий "' . $request->input('comment') . '"'];
        }
        if (
            Auth::user()->hasRole(['administrator']) &&
            $request->input('responsible') != $model->responsible
        ) {
            $model->responsible = $request->input('responsible');
            $actions[] = ['Был изменен ответственный.'];
        }

        // Increment Payment
        if ($request->input('status') === 'withdrawn') {
            if ($this->transactionPaymentBK($request, $model->currency)) {
                $sum = 0;
                foreach ($request->input('transactions') as $transaction) {
                    $paymentModel = Payments::whereId($transaction['payment_id'])
                        ->with(['type', 'country'])
                        ->first();
                    $sum += $transaction['sum'];
                    $actions[] = ['Выведено на платежку '. implode(' ', [
                            $paymentModel['country']['name'],
                            $paymentModel['drop'],
                            $paymentModel['type']['title'],
                        ]) . ' - сумма '. $transaction['sum']];
                }
                $model->sum = $model->sum - $sum;
            }
        }

        if ($stories = $this->storeBkStories($id, $actions)) {
            return redirect()->back()->withErrors($stories);
        }
        $model->save();
        // Update statistics for BK
        if (! (new StatisticsController())->update($id)) {
            return redirect()->back(500)->withErrors($stories);
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param string $currencies
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function transactionPaymentBK(Request $request, string $currencies)
    {
        if ($request->has('transactions')) {
            foreach ($request->input('transactions') as $transaction) {
                if (! (new PaymentController())->incrementSum(
                    (int) $transaction['payment_id'],
                    (int) $transaction['sum'],
                    $currencies
                )) return redirect()->back(500);
            }
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     * @param array $actions
     * @return mixed
     */
    public function storeBkStories(int $id, array $actions)
    {
        try {
            foreach (array_values($actions) as $action) {
                BkStories::create([
                    'bk_id' => $id,
                    'action' => implode('', $action),
                    'user' => Auth::user()->name
                ]);
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }
}
