<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePerActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('per_actions', function (Blueprint $table) {
            $table->foreign('id_per')->references('id')->on('permissions');
            $table->foreign('id_per_detail')->references('id')->on('permission__details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('per_actions', function (Blueprint $table) {
            //
        });
    }
}
