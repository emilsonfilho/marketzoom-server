<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'slogan',
        'profile',
        'active',
    ];

    /**
     * Get all of the users for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user associated with the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
