<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'origin', 'discount', 'published_at'];

    /**
     * Get the product that owns this price.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
