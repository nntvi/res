<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_order_table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_bill');
            $table->unsignedBigInteger('id_dish');
            $table->bigInteger('price');
            $table->bigInteger('qty');
            $table->enum('status', ['0', '1']);
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
        Schema::dropIfExists('detail_order_table');
    }
}