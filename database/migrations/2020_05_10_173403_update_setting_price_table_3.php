<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSettingPriceTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_price', function (Blueprint $table) {
            $table->bigInteger('sltra')->after('gianhapsau');
            $table->bigInteger('giatra')->after('sltra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_price', function (Blueprint $table) {
            //
        });
    }
}