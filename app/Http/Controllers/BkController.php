<?php

namespace App\Http\Controllers;

use App\Models\Bks as BkModel;
use App\Models\Pivot\BkStories;
use App\Models\User;
use App\Resources\BK\BkItemResources;
use App\Resources\BK\BksResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\StatisticsController;

class BkController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'userResponsible:id,name'])
            ->where('responsible', Auth::id());
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
    public function distribution(): \Inertia\Response
    {
        $builder = BkModel::with(['country:id,name', 'bet:id,name', 'userResponsible'])
            ->where('status', 'new');
        return Inertia::render('Bk/Distribution', [
            'data' => new BksResources($builder->get()),
            'filter' => [
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function distributionSave(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            BkModel::where('id', (int) $request->input('id'))
                ->update([
                    'responsible' => (int) $request->input('responsible'),
                    'status' => 'waiting'
                ]);
            (new StatisticsController())->create($request->input('id'));
            return response()->json('Изменено.');
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
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
            'responsible' => User::all()
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(int $id, Request $request): \Illuminate\Http\JsonResponse
    {
        $model = BkModel::find($id);
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
        if ($request->input('status') != $model->status) {
            $model->status = $request->input('status');
            array_push($actions, ['Статус изменен с "' . $model->statuses . '" на "' . BkModel::STATUSES[$request->input('status')] . '"']);
        }
        if ($request->filled('comment')) {
            array_push($actions, ['Добавлен комментарий "' . $request->input('comment') . '"']);
        }
        if (
            Auth::user()->hasRole(['administrator']) &&
            $request->input('responsible') != $model->responsible
        ) {
            $model->responsible = $request->input('responsible');
            array_push($actions, ['Был изменен ответственный.']);
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
