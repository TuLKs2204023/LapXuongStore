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
        // Insert new record for 'demands' table for testing
        DB::table('demands')->insert(
            array(
                [
                    'name' => 'Office',
                    'slug' => 'office',
                    'image' => 'banner-001.jpg'
                ],
                [
                    'name' => 'Gaming',
                    'slug' => 'gaming',
                    'image' => 'banner-002.jpg'
                ],
                [
                    'name' => 'Graphics',
                    'slug' => 'graphics',
                    'image' => 'banner-003.jpg'
                ],
                [
                    'name' => 'Student',
                    'slug' => 'student',
                    'image' => 'banner-004.jpg'
                ],
                [
                    'name' => 'Slim',
                    'slug' => 'slim',
                    'image' => 'banner-005.jpg'
                ],
                [
                    'name' => 'Workstation',
                    'slug' => 'workstation',
                    'image' => 'banner-006.jpg'
                ],
            )
        );
        // Insert new record for 'cate_groups' table for testing
        DB::table('cate_groups')->insert(
            array(
                'name' => 'Demand',
                'slug' => 'demand'
            )
        );

        //alter products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('demand_id')->default(1)->after('screen_id')->constrained();
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
