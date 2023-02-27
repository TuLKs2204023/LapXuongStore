<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('specification', function (Blueprint $table) {
            $table->id();
            $table->integer('manufacture_id')->unsigned();
            $table->string('name');
            $table->double('price');
            $table->string('description')->nullable();
            $table->string('tag')->nullable();
            $table->string('addtocart')->nullable();
            $table->string('availability')->nullable();
            $table->double('weight')->nullable();
            $table->string('display')->nullable();
            $table->string('webcam')->nullable();
            $table->string('graphics')->nullable();
            $table->string('processor')->nullable();
            $table->string('dimension')->nullable();
            $table->string('color')->nullable();

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
        Schema::dropIfExists('specification');
    }
};
