<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop 'stock_id' column
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign('prices_stock_id_foreign');
            $table->dropColumn('stock_id');
            $table->dropColumn('discount');
            $table->integer('sale_discounted')->after('sale')->default(0);
        });

        // Delete old sale records
        DB::table('prices')->where('sale', '>', 0)->delete();

        // Add new salePrice records
        $products = Product::all();
        foreach ($products as $product) {
            // if ($product->id == 30) continue;
            $salePrice = $product->salePrice();
            $discount = $product->latestDiscount();
            $product->prices()->create(['sale_discounted' => $salePrice * (1 - $discount), 'sale' => $salePrice]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
