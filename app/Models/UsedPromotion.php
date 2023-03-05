<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UsedPromotion extends Model
{
    use HasFactory;

    protected $fillable = ['promotion_id'];

    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }

    public function promotion():BelongsTo{
        return $this->belongsTo(Promotion::class);
    }
}
