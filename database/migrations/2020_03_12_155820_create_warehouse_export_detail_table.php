<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseExportDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_warehouse_export', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code_export');
            $table->unsignedBigInteger('id_material_detail');
            $table->bigInteger('qty');
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
        Schema::dropIfExists('detail_warehouse_export');
    }
}
