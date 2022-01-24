<?php

namespace App\Http\Controllers;

use App\Models\Bks as BkModel;
use App\Models\Pivot\BkStories;
use App\Resources\BK\BkItemResources;
use App\Resources\BK\BksResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class BkController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name']);
        if ($request->filled($request->query('country'))) {
            $builder->where('country_id', $request->query('country'));
        }
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
        return Inertia::render('Bk/Edit', [
            'item' => new BkItemResources($builder),
            'statuses' => BkModel::STATUSES,
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $model = BkModel::find($id);
        Validator::make($request->all(), [
            'comment' => ['required', 'string'],
        ])->validate();
        $actions = [];
        if ($request->input('email') != $model->email) {
            $model->email = $request->input('email');
            array_push($actions, ['Логин почты изменен с "' . $model->email . '" на "' . $request->input('email') . '"']);
        }
        if ($request->input('password') != $model->password) {
            $model->email = $request->input('password');
            array_push($actions, ['Пароль почты изменен с "' . $model->password . '" на "' . $request->input('password') . '"']);
        }
        if ($request->input('info') != $model->info) {
            $model->info = $request->input('info');
            array_push($actions, ['Доп.информация изменена с "' . $model->info . '" на "' . $request->input('info') . '"']);
        }
        if ($request->input('sum') != $model->sum) {
            $model->sum = $request->input('sum');
            array_push($actions, ['Сумма изменена с "' . $model->sum . '" на "' . $request->input('sum') . '"']);
        }
        if ($request->input('status.key') != $model->status) {
            $model->info = $request->input('status.key');
            array_push($actions, ['Статус изменен с "' . $model->statuses . '" на "' . $request->input('status.value') . '"']);
        }
        array_push($actions, ['Добавлен комментарий "' . $request->input('comment') . '"']);

        if (
            Auth::user()->hasRole(['Administrator']) &&
            $request->input('responsible') != $model->responsible
        ) {
            $model->responsible = $request->input('responsible');
        }
        $model->save();
        if ($stories = $this->storeBkStories($id, $actions)) {
            return response()->json($stories, 500);
        }
        return response()->json('Изменено.');
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
