<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'manufacture_id', 'cpu_id', 'description'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['price', 'price_id'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['prices', 'latestPrice'];

    /**
     * Get the product's price attribute.
     */
    public function getPriceAttribute()
    {
        return $this->latestPrice->origin ?? 0;
    }
    /**
     * Get the product's price_id attribute.
     */
    public function getPriceIdAttribute()
    {
        return $this->latestPrice->id ?? 0;
    }

    /**
     * Get the Prices for product
     */
    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id');
    }


    /**
     * Get the current pricing for the product.
     */
    public function currentPrice()
    {
        return $this->hasOne(Price::class)->ofMany([
            'published_at' => 'max',
            'id' => 'max',
        ], function ($query) {
            $query->where('published_at', '<', now());
        });
    }

    /**
     * Get the product's most recent price.
     */
    public function latestPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany();
    }

    /**
     * Get the product's oldest price.
     */
    public function oldestPrice()
    {
        return $this->hasOne(Price::class)->oldestOfMany();
    }

    /**
     * Get the Order Details for product
     */
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    /**
     * Get all of the product's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get the product's most recent image.
     */
    public function latestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->latestOfMany();
    }

    /**
     * Get the product's oldest image.
     */
    public function oldestImage()
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }

    /**
     * Get the manufacture that owns this product.
     */
    public function manufacture()
    {
        return $this->belongsTo(Cates\Manufacture::class, 'manufacture_id');
    }

    /**
     * Get the cpu that owns this product.
     */
    public function cpu()
    {
        return $this->belongsTo(Cates\Cpu::class, 'cpu_id');
    }
}
