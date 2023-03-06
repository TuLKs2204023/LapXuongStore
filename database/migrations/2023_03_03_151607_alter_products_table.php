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
        // Insert new record for 'hdds' table for testing
        DB::table('hdds')->insert(
            array(
                'amount' => 256,
                'name' => '256 GB',
                'slug' => '256-gb'
            )
        );
        // Insert new record for 'cate_groups' table for testing
        DB::table('cate_groups')->insert(
            array(
                'name' => 'HDD',
                'slug' => 'hdd'
            )
        );

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('hdd_id')->default(1)->after('ram_id')->constrained();
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
