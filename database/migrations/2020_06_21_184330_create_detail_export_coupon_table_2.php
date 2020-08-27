<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailExportCouponTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_export_coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_excoupon');
            $table->string('code_export');
            $table->string('name_object');
            $table->unsignedBigInteger('id_object');
            $table->unsignedBigInteger('id_material_detail');
            $table->float('qty');
            $table->unsignedBigInteger('id_unit');
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
        Schema::dropIfExists('detail_export_coupon');
    }
}
