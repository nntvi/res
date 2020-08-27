<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHistoryWhcookTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_whcook', function (Blueprint $table) {
            $table->foreign('id_cook')->references('id')->on('cook_area');
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
        Schema::table('history_whcook', function (Blueprint $table) {
            //
        });
    }
}
