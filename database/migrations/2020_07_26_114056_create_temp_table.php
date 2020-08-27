<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->enum('status',['-1','0','1']);
            $table->bigInteger('total_price');
            $table->bigInteger('receive_cash');
            $table->bigInteger('excess_cash');
            $table->string('note');
            $table->string('created_by');
            $table->string('payer');
            $table->unsignedBigInteger('id_shift');
            $table->time('time_created');
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
        Schema::dropIfExists('temp');
    }
}
