<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

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
    protected $policies = [
        Banner::class => BannerPolicy::class,
        Cart::class => CartPolicy::class,
        Category::class => CategoryPolicy::class,
        Comment::class => CommentPolicy::class,
        Product::class => ProductPolicy::class,
        Shop::class => ShopPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
