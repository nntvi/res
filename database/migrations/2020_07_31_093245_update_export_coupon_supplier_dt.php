<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExportCouponSupplierDt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('export_coupon_supplier_dt', function (Blueprint $table) {
            $table->string('code_import')->after('id_exsupplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('export_coupon_supplier_dt', function (Blueprint $table) {
            //
        });
    }
}
