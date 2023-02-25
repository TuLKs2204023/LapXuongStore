<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount'];

    public function order(): HasOne{
        return $this->hasOne(Order::class);
    }

    public function usedPromotion():HasOne{
        return $this->hasOne(UsedPromotion::class);
    }

    public function isAvailable(){
        $id = $this->id;
        $usedPromotion = DB::table('used_promotions')->where('promotion_id', $id)->first();
        if($usedPromotion){
            $this->status = 0;
            return true; //true
        }
        else{
            return false; //false
        }
    }
}
