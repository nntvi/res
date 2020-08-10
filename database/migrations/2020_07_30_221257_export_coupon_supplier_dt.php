<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExportCouponSupplierDt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_coupon_supplier_dt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_exsupplier');
            $table->unsignedBigInteger('id_material_detail');
            $table->bigInteger('qty');
            $table->bigInteger('price');
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
        Schema::dropIfExists('export_coupon_supplier_dt');
    }
}
