<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_date', 'name', 'phone', 'email', 'address', 'notes', 'payment'];

    /**
     * Get the Order Details for this Order
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function usedPromotion(): HasOne
    {
        return $this->hasOne(UsedPromotion::class);
    }
}
