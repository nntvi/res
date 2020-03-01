<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_action', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_groupmenu');
            $table->unsignedBigInteger('id_material_detail');
            $table->unsignedBigInteger('id_dvt');
            $table->bigInteger('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_action');
    }
}
