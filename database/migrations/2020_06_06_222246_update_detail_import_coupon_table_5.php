<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailImportCouponTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_import_coupon', function (Blueprint $table) {
            $table->foreign('id_imcoupon')->references('id')->on('import_coupons');
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
        Schema::table('detail_import_coupon', function (Blueprint $table) {
            //
        });
    }
}
