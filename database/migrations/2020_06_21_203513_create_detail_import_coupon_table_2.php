<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailImportCouponTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_import_coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_imcoupon');
            $table->string('code_import');
            $table->unsignedBigInteger('id_material_detail');
            $table->float('qty');
            $table->unsignedBigInteger('id_unit');
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
        Schema::dropIfExists('detail_import_coupon');
    }
}
