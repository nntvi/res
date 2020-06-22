<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMaterialActionTable6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_action', function (Blueprint $table) {
            $table->foreign('id_groupnvl')->references('id')->on('materials');
            $table->foreign('id_material_detail')->references('id')->on('material_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_action', function (Blueprint $table) {
            //
        });
    }
}
