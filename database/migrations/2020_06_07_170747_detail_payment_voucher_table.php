<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailPaymentVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_payment_voucher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_paymentvc');
            $table->foreign('id_paymentvc')->references('id')->on('payment_voucher');
            $table->unsignedBigInteger('id_material_detail');
            $table->float('qty');
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
        Schema::dropIfExists('detail_payment_voucher');
    }
}
