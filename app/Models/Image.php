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
}
