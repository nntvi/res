<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryWhcookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_whcook', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_cook');
            $table->unsignedBigInteger('id_material_detail');
            $table->float('first_qty');
            $table->float('last_qty');
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
        Schema::dropIfExists('history_whcook');
    }
}
