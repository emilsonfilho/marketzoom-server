<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\AuthUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function store(AuthUserRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw AuthException::invalidCredentials();
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken($user->name)->plainTextToken,
        ]);
    }

    /**
     * POST api/auth/logout
     *
     * Logout an user
     */
    public function logout()
    {
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }

    public function show()
    {
        $user = auth()->user();

        return response()->json([
            "user" => $user
        ]);
    }
}
