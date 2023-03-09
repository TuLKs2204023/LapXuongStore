<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'manufacture_id', 'description'];

    /**
     * Get the series's cates.
     */
    public function cate()
    {
        return $this->morphOne(\App\Models\Cate::class, 'cateable');
    }

    /**
     * Get the products for the series.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    /** 
     * Get the Manufacture that owns this Series.
     */
    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class, 'manufacture_id');
    }
}
