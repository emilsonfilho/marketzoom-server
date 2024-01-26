<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Usuário', description: 'Gestão de usuários')]
class UserController extends Controller
{
    /**
     * POST api/users
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $result = User::create($request->validated());

        return response()->json(new UserResource($result->load('userType')));
    }

    /**
     * GET api/users/{user}
     *
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user->load(['userType', 'shop', 'shop.admin'])));
    }

    /**
     * PUT api/users/{user}
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json(new UserResource($user->load(['userType', 'shop', 'shop.admin'])));
    }

    /**
     * PUT api/users/{user}/reset-password
     */
    public function resetPassword(UpdateUserPasswordRequest $request, User $user): JsonResponse
    {
        $request->validated();

        $user->update([
            'password' => bcrypt($request->get('new_password')),
        ]);

        return response()->json(new UserResource($user->load(['userType', 'shop', 'shop.admin'])));
    }

    /**
     * DELETE api/users/{user}
     *
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * POST api/users/{user}/salesperson
     *
     * Makes someone a salesperson
     */
    public function makingSalesperson(User $user): JsonResponse
    {
        $user->update([
            'user_type_id' => 2
        ]);

        return response()->json(new UserResource($user->load(['userType', 'shop', 'shop.admin'])));
    }
}
