<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['rate', 'review', 'product_id','parent_id'];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function replies(){
        return $this->hasMany(Rating::class,'parent_id');
    }
}
