<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderTableTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_table', function (Blueprint $table) {
            $table->bigInteger('receive_cash')->after('total_price');
            $table->bigInteger('excess_cash')->after('receive_cash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_table', function (Blueprint $table) {
            //
        });
    }
}
