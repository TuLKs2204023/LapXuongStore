<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Description extends Model
{
    use HasFactory;

    protected $fillable = ['instruction', 'feature', 'weight', 'dimension', 'webcam', 'o_s', 'battery', 'warranty'];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
