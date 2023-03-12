<?php

namespace App\Models;

use App\Http\Traits\ProcessModelData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;
    use ProcessModelData;

    protected $fillable = ['rate', 'review', 'product_id'];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function timeRating(){
        $now = Carbon::now();
        $duration = $this->duration($now, $this->created_at);
        return $duration;
    }
}
