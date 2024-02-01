<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShopPolicy
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
     * Determine whether the user can store a shop
     */
    public function store(User $user): bool
    {
        return $user->user_type_id === 2;
    }

    /**
     * Determine whether the user can update a shop.
     */
    public function update(User $user, Shop $shop): bool
    {
        return $user->id === $shop->admin_id;
    }

    /**
     * Determine whether the user can delete a shop.
     */
    public function delete(User $user, Shop $shop): bool
    {
        return $user->id === $shop->admin_id;
    }
}
