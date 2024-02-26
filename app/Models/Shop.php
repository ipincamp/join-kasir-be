<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get all of the shopOwners for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopOwners(): HasMany
    {
        return $this->hasMany(ShopOwner::class);
    }

    /**
     * Get the shopSetting associated with the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shopSetting(): HasOne
    {
        return $this->hasOne(ShopSetting::class);
    }
}
