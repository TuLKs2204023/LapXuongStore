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
        // Insert new record for 'colors' table for testing
        DB::table('colors')->insert(
            array(
                'name' => 'White',
                'slug' => 'white'
            )
        );
        // Insert new record for 'cate_groups' table for testing
        DB::table('cate_groups')->insert(
            array(
                'name' => 'Color',
                'slug' => 'color'
            )
        );
        
        //alter products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('color_id')->default(1)->after('screen_id')->constrained();
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
