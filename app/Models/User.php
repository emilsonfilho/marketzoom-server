<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type_id',
        'shop_id',
        'name',
        'email',
        'password',
        'profile',
    ];

    protected $attributes = [
        'user_type_id' => 3,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get the shop that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Get the administredShop associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administredShop(): HasOne
    {
        return $this->hasOne(Shop::class, 'admin_id');
    }

    /**
     * Get the userType that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    /**
     * Get all of the car for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
