<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_date', 'shipping_name', 'shipping_phone', 'shipping_email', 'shipping_address', 'promotion_id'];

    /**
     * Get the Order Details for this Order
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function promotion(): BelongsTo{
        return $this->belongsTo(Promotion::class);
    }

    public function usedPromotion():HasOne{
        return $this->hasOne(UsedPromotion::class);
    }
}
