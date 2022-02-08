<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Bks;
use App\Models\Statistics;
use App\Models\User;
use App\Resources\User\UsersResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{

    /**
     * @return Response
     */
    public function index(): Response
    {
        $builder = User::all();
        return Inertia::render('Users', [
            'data' => new UsersResources($builder)
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    /**
     * @param Request $request
     * @param CreateNewUser $creator
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, CreateNewUser $creator): RedirectResponse
    {
        $builder = $creator->create($request->all());
        $builder->assignRole($request->input('role'));
        return redirect()->back();
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        $user = User::find($id);
        return Inertia::render('User/Edit', [
            'data' => $user
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        if ($user->email != $request->input('email')) {
            $user->email = $request->input('email');
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        if (! $user->hasRole($request->input('role'))) {
            $user->assignRole($request->input('role'));
        }
        return redirect()->back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        // Update BK
        Bks::where('responsible', $id)
            ->update([
                'responsible' => null
            ]);
        // Delete statistics
        Statistics::where('responsible', $id)
            ->delete();

        User::destroy([$id]);
        return redirect()->back();
    }

}
