<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Address\Ward;
use App\Models\Address\City;
use App\Models\Address\District;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'phone',
        'image',
        'gender',
        'google_id',
        'facebook_id',
        'city_id',
        'district_id',
        'ward_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function latestRate()
    {
        return Rating::where('user_id', $this->id)->get()->last();
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function histories()
    {
        return $this->hasMany(HistoryUser::class);
    }
    public function historyProduct()
    {
        return $this->HasMany(HistoryProduct::class);
    }
    public function historyRating()
    {
        return $this->HasMany(HistoryRating::class);
    }

    public function boughtProduct($productId)
    {
        $orderDetails = OrderDetail::where('product_id', $productId)->get();
        if (count($orderDetails) > 0) {
            foreach ($orderDetails as $item) {
                $oId = $item->order_id;
                $boughtProduct = Order::where('user_id', $this->id)->where('id', $oId)->get()->first();
                if ($boughtProduct && $boughtProduct->statusProcessing() == 'Ready for pickup') {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
