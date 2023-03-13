<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_date', 'name', 'phone', 'email', 'address', 'notes', 'payment', 'city', 'district', 'ward'];

    /**
     * Get the Order Details for this Order
     */
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function usedPromotion(): HasOne
    {
        return $this->hasOne(UsedPromotion::class);
    }

    //get user own that order
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //Check promotion by order
    public function isPromoted()
    {
        $oId = $this->id;
        $isPromoted = DB::table('used_promotions')->where('order_id', $oId)->get()->first();
        if ($isPromoted) {
            return true; //true
        } else {
            return false; //false
        }
    }

    //Get promotion discount 
    public function discount()
    {
        $isPromoted = $this->isPromoted();
        if ($isPromoted) {
            $discount = $this->usedPromotion->promotion->discount;
            return $discount;
        } else {
            $discount = 0;
            return $discount;
        }
    }

    //Total Value of an order
    public function total()
    {
        $total = 0;
        $oId = $this->id;
        $items = OrderDetail::where('order_id', $oId)->get();
        foreach($items as $item){
            $total += $item->product->fakePrice() * $item->quantity;
        }
        return $total;
    }

    //Discount amount
    public function discountAmount(){
        $total = $this->total();
        $discount = $this->discount();
        return $total * $discount;
    }

    //Total after discount
    public function totalAfterDiscount(){
        $total = $this->total();
        $afterDis = $this->discountAmount();
        return $total - $afterDis;
    }
}
