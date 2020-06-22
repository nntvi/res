<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailOrderTableTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_order_table', function (Blueprint $table) {
            $table->foreign('id_bill')->references('id')->on('order_table');
            $table->foreign('id_dish')->references('id')->on('dishes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_order_table', function (Blueprint $table) {
            //
        });
    }
}
