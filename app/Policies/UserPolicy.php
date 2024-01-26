<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user): bool|null
    {
        if ($user->userType()->get('id') === 1) {
            return true;
        }

        return null;
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function makeSalesperson(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    // Policy para poder se excluir
    public function deleteAccount(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
