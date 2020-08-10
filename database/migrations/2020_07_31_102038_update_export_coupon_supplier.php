<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExportCouponSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('export_coupon_supplier', function (Blueprint $table) {
            $table->string('code')->after('id');
            $table->dropColumn('id_imcoupon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('export_coupon_suppplier', function (Blueprint $table) {
            //
        });
    }
}
