<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailExportCouponTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_export_coupon', function (Blueprint $table) {
            $table->dropColumn('id_export_coupon');
            $table->foreign('id_excoupon')->references('id')->on('export_coupons');
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
