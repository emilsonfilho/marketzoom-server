<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Http\Requests\AuthUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        ]);
    }
}
