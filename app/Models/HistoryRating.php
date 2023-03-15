<?php

namespace App\Models;

use App\Http\Traits\ProcessModelData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRating extends Model
{
    use ProcessModelData;
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'rating',
        'review',
        'action',

    ];
    public function time()
    {
        $now = Carbon::now();
        $duration = $this->duration($now, $this->created_at);
        return $duration;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}

