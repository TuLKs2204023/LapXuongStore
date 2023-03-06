<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert new record for 'series' table for testing
        DB::table('series')->insert(
            array(
                'name' => 'Macbook Pro',
                'slug' => 'macbook-pro'
            )
        );
        // Insert new record for 'cate_groups' table for testing
        // DB::table('cate_groups')->insert(
        //     array(
        //         'name' => 'Demand',
        //         'slug' => 'demand'
        //     )
        // );
        
        //alter products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('series_id')->default(1)->after('screen_id')->constrained();
        });
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
