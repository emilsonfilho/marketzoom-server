<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAllowedException;
use App\Http\Resources\UserTypeResource;
use App\Models\UserType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Knuckles\Scribe\Attributes\Group;

#[Group(name: 'Tipos de Usuário', description: 'Gestão dos tipos de usuários')]
class UserTypeController extends Controller
{
    /**
     * GET api/user_types
     *
     * Display a listing of the user_types.
     */
    public function index(): JsonResponse
    {
        if (Gate::denies('is-admin')) return NotAllowedException::notAllowed();

        return response()->json(UserTypeResource::collection(UserType::all()));
    }

    /**
     * GET api/user_types/{userType}
     *
     * Display the specified user_type.
     */
    public function show(UserType $userType): JsonResponse
    {
        if (Gate::denies('is-admin')) return NotAllowedException::notAllowed();

        return response()->json(new UserTypeResource($userType));
    }
}
