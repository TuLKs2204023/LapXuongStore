<?php

namespace App\Models\Cates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hdd extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'amount', 'description'];

    /**
     * Get the products for the Ram.
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
