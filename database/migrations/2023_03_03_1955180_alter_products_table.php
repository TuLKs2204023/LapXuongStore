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
        DB::table('resolutions')->insert(
            array(
                [
                    'name' => '540p',
                    'slug' => '540p'
                ],
                [
                    'name' => '720p',
                    'slug' => '720p'
                ],
                [
                    'name' => '1080p',
                    'slug' => '1080p'
                ],
                [
                    'name' => '2K',
                    'slug' => '2k'
                ],
                [
                    'name' => '1440p',
                    'slug' => '1440p'
                ],
                [
                    'name' => '2160p',
                    'slug' => '2160p'
                ],
                [
                    'name' => '4K',
                    'slug' => '4k'
                ],
                [
                    'name' => '5K',
                    'slug' => '5k'
                ],
                [
                    'name' => '8K',
                    'slug' => '8k'
                ],
            )
        );
        // Insert new record for 'cate_groups' table for testing
        DB::table('cate_groups')->insert(
            array(
                'name' => 'Resolution',
                'slug' => 'resolution'
            )
        );

        //alter products
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('resolution_id')->default(1)->after('screen_id')->constrained();
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
