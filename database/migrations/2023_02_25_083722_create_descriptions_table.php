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
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->longText('instruction')->nullable();
            $table->longText('feature')->nullable();
            $table->float('weight')->nullable();
            $table->string('dimension')->nullable();
            $table->string('webcam')->nullable();
            $table->string('o_s')->nullable();
            $table->integer('battery')->nullable();
            $table->integer('warranty')->nullable();
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
        Schema::dropIfExists('descriptions');
    }
};
