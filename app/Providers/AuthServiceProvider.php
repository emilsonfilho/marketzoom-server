<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Policies\BannerPolicy;
use App\Policies\CartPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ShopPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            if ($user->user_type_id === 1) {
                return true;
            }
        });

        /* BANNERS GATES */
        Gate::define('create-banner', function ($user): bool {
            return $user->user_type_id === 1;
        });

        Gate::define('delete-banner', function ($user): bool {
            return $user->user_type_id === 1;
        });

        /* CATEGORIES GATES */
        Gate::define('create-category', function ($user): bool {
            return $user->user_type_id === 1;
        });

        Gate::define('update-category', function ($user): bool {
            return $user->user_type_id === 1;
        });

        Gate::define('delete-category', function ($user): bool {
            return $user->user_type_id === 1;
        });

        /* CCMMENT GATES */
        Gate::define('update-comment', function ($user, $comment): bool {
            return $user->id === $comment->user_id;
        });

        Gate::define('delete-comment', function ($user, $comment): bool {
            return $user->id === $comment->user_id;
        });

        /* PRODUCT GATES */
        Gate::define('create-product', function ($user): bool {
            return $user->user_type_id === 2;
        });

        Gate::define('update-product', function ($user, $product): bool {
            return $user->id === $product->user_id || ($user->shop_id === $product->shop_id && $user->shop_id !== null && $product->shop_id !== null);
        });

        Gate::define('delete-product', function ($user, $product): bool {
            return $user->id === $product->user_id || ($user->shop_id === $product->shop_id && $user->shop_id !== null && $product->shop_id !== null);
        });

        /* SHOP GATES */
        Gate::define('create-shop', function ($user): bool {
            return $user->user_type_id === 2;
        });

        Gate::define('update-shop', function ($user, $shop): bool {
            return $user->id === $shop->admin_id;
        });

        Gate::define('delete-shop', function ($user, $shop): bool {
            return $user->id === $shop->admin_id;
        });

        /* USER GATES */
        Gate::define('udpate-user', function ($user, $model): bool {
            return $user->id === $model->id;
        });

        Gate::define('makes-salesperson', function ($user, $model): bool {
            return $user->id === $model->id;
        });

        Gate::define('delete-account', function ($user, $model): bool {
            return $user->id === $model->id;
        });

        /* GENERAL GATES */
        Gate::define('is-user', function ($user): bool {
            return User::where('id', $user->id)->exists();
        });

        Gate::define('is-admin', function ($user): bool {
            return $user->user_type_id === 1;
        });

        $this->registerPolicies();
    }
}
