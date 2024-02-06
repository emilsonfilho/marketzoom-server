<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\AuthUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symphony\Component\HttpFoundation\Response;

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
            'user_id' => $user->id,
            'user_name' => $user->name,
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
}
