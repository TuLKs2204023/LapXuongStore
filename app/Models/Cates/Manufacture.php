<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'address', 'phone', 'description'];


    /**
     * Get the manufacture's images.
     */
    public function image()
    {
        return $this->morphOne(\App\Models\Image::class, 'imageable');
    }

    /**
     * Get the manufacture's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the products for the manufacture.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
