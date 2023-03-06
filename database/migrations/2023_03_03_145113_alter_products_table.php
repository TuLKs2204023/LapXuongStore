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
        // Insert new record for 'screens' table for testing
        DB::table('screens')->insert(
            array(
                'amount' => 14.0,
                'name' => '14.0 inch',
                'slug' => '14-0-inch'
            )
        );
        // Insert new record for 'cate_groups' table for testing
        DB::table('cate_groups')->insert(
            array(
                'name' => 'Screen',
                'slug' => 'screen'
            )
        );
        
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('screen_id')->default(1)->after('ram_id')->constrained();
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
