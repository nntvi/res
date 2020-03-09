<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_warehouse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_import');
            $table->unsignedBigInteger('id_good');
            $table->bigInteger('qty');
            $table->unsignedBigInteger('id_unit');
            $table->bigInteger('price');

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
        Schema::dropIfExists('detail_warehouse');
    }
}
