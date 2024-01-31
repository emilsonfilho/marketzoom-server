<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->userType()->get('id') === 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->userType()->get('id') === 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->userType()->get('id') === 1;
    }
}
