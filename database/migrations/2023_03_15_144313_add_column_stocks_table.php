<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->foreignId('price_id')->after('product_id')->default(12)->constrained()->onDelete('cascade');
        });

        $stocks = Stock::all();
        foreach ($stocks as $stock) {
            $price = DB::table('prices')
                ->where([
                    ['product_id', $stock->product_id],
                    ['origin', '>', 0],
                ])
                ->get()
                ->last();

            $stock->price_id = $price->id;
            $stock->save();
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
