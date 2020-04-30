<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderTableTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_table', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->after('note');
            $table->unsignedBigInteger('id_shift')->after('created_by');
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
