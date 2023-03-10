<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'origin', 'stock_id', 'discount', 'published_at'];

    /**
     * Get the product that owns this price.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function stock(){
        return $this->belongsTo(Stock::class);
    }
}
