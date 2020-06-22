<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWarehouseTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouse', function (Blueprint $table) {
            $table->foreign('id_type')->references('id')->on('type_material');
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
        Schema::table('warehouse', function (Blueprint $table) {
            //
        });
    }
}
