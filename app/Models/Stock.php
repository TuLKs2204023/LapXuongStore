<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['in_qty', 'out_qty'];

    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function price(){
        return $this->hasOne(Price::class);
    }

    public function getPrice()
    {
        return DB::table('prices')
            ->where('stock_id', $this->id)->first();
    }

    public function order_detail(){
        return $this->hasOne(OrderDetail::class);
    }
}
