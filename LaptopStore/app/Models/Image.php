<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    /**
     * Get the parent imageable model (Product or Manufacture or ...)
     */
    public function imageable()
    {
        return $this->morphTo();
    }
    public function product(){
        return $this->belongsTo(Product::class,'imageable_id','id');
    }
    public function cate(){
        return $this->belongsTo(CateGroup::class,'imageable_id','id');
    }
}
