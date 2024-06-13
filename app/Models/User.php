<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function favorites():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_user');
    }

    public function hasFavorite($favorite_id):bool
    {
        return $this->favorites()->where('product_id',$favorite_id)->exists();
    }

    public function addresses():HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function settings():HasMany
    {
        return $this->hasMany(UserSetting::class,'user_id','id');
    }

    public function paymentCards():HasMany
    {
        return $this->hasMany(UserPaymentCard::class);
    }
}
