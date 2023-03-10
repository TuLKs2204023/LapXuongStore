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
        DB::table('cate_groups')->insert(
            array(
                [
                    'name' => 'Manufacture',
                    'slug' => 'manufacture'
                ],
                [
                    'name' => 'Series',
                    'slug' => 'series'
                ],
                [
                    'name' => 'CPU',
                    'slug' => 'cpu'
                ],
                [
                    'name' => 'GPU',
                    'slug' => 'gpu'
                ],
                [
                    'name' => 'RAM',
                    'slug' => 'ram'
                ],
            )
        );

        Schema::create('cates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('cate_groups_id')->constrained();
            $table->string('description')->nullable();
            $table->bigInteger('cateable_id');
            $table->string('cateable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cates');
    }
};
