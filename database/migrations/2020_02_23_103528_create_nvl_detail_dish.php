<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNvlDetailDish extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_detail_dish', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_mat_detail');
            $table->unsignedBigInteger('id_dvt');
            $table->unsignedBigInteger('id_dish');
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
        Schema::dropIfExists('material_detail_dish');
    }
}
