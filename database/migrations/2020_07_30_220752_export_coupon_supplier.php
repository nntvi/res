<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExportCouponSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_coupon_supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_imcoupon');
            $table->bigInteger('total');
            $table->string('note');
            $table->string('created_by');
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
        Schema::dropIfExists('export_coupon_supplier');
    }
}
