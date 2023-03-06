<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Get the color's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the products for the color.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
