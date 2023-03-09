<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'stock_id', 'order_id', 'quantity'];

    /**
     * Get the Order that owns this Order Detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the Product that owns this Order Detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the Price that owns this Order Detail.
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    /**
     * Get the Stock that owns this Order Detail.
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
