<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Get the gpu's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the products for the gpu.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
