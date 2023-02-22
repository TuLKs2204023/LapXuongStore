<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        // Insert new record for 'rams' table for testing
        // DB::table('rams')->insert(
        //     array(
        //         'amount' => 1,
        //         'name' => '1 GB',
        //         'slug' => '1-gb'
        //     )
        // );

        // Insert ram_id column for 'products' table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('ram_id')->after('cpu_id')->constrained();
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
