<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use App\Resources\User\UsersResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        $builder = $creator->create($request->all());
        $builder->assignRole($request->input('role'));
        return new JsonResponse('', 200);
    }

}
