<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Get the demand's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the products for the demand.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
