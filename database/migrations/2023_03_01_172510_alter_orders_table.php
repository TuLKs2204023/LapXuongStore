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
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('shipping_name', 'name');
            $table->renameColumn('shipping_phone', 'phone');
            $table->renameColumn('shipping_email', 'email');
            $table->renameColumn('shipping_address', 'address');
            $table->text('notes')->after('shipping_address')->nullable();
            $table->integer('payment')->after('notes');
            $table->integer('promotion_id')->after('payment')->nullable();
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
