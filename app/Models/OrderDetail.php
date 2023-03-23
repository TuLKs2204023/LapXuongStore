<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'stock_id', 'order_id', 'quantity'];

    /**
     * Get the Order that owns this Order Detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the Product that owns this Order Detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the Price that owns this Order Detail.
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    /**
     * Get the Stock that owns this Order Detail.
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function time()
    {
        $now = Carbon::now();
        $durationPro = $this->duration($now, $this->created_at);
        return $durationPro;
    }

     // Caculate records for the admin reports : Dự
     private function checkCancelled()
     {
         $check = DB::table('orders')->where('id', $this->order_id)->sum('status');
         return $check;
     }
     public function printQuantity(){
         if($this->checkCancelled() >0){
             $qty=$this->quantity;
         }
         else $qty=0;
         return $qty;
     }
     private function checkPromotion(){
         $check= DB::table('used_promotions')->where('order_id',$this->order_id)->sum('promotion_id');
         if($check >0){
             $pro=DB::table('promotions')->where('id',$check)->sum('discount');
         }
         else $pro =0;
         return $pro;
 
     }
     public function printPrice(){
         $product= DB::table('products')->where('id',$this->product_id)->sum('id');
         $price=DB::table('prices')->where('product_id',$product)->sum('sale_discounted') - DB::table('prices')->where('product_id',$product)->sum('sale_discounted') *$this->checkPromotion();
         return $price;
     }
     private function printOutqty(){
         $product=DB::table('stocks')->where('id',$this->stock_id)->sum('out_qty');
         return $product;
     }
     public function printRevenue(){
         if($this->checkCancelled() >0){
             $rev= $this->printPrice() *$this->printOutqty();
         }
         else $rev=0;
         return $rev;
     }
 // End of function : Dự
}
