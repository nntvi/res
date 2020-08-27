<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailExportCouponTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_export_coupon', function (Blueprint $table) {
            $table->unsignedBigInteger('id_excoupon')->after('id');
            $table->string('name_object')->after('code_export');
            $table->foreign('id_material_detail')->references('id')->on('material_details');
            $table->foreign('id_unit')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_export_coupon', function (Blueprint $table) {
            //
        });
    }
}
