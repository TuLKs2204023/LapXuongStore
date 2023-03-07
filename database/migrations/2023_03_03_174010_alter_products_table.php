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
        // Insert new record for 'gpus' table for testing
        DB::table('gpus')->insert(
            array(
                'name' => 'Nvidia A100',
                'slug' => 'nvidia-A100'
            )
        );
        // Insert new record for 'cate_groups' table for testing
        // DB::table('cate_groups')->insert(
        //     array(
        //         'name' => 'GPU',
        //         'slug' => 'gpu'
        //     )
        // );
        
        //alter products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('gpu_id')->default(1)->after('screen_id')->constrained();
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
