<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_price', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_material_detail');
            $table->float('sltontruoc');
            $table->bigInteger('giatontruoc');
            $table->float('sltonsau');
            $table->bigInteger('giatonsau');
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
        Schema::dropIfExists('setting_price');
    }
}
