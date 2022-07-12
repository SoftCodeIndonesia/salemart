<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->string('user_devices_id',255)->primary();
            $table->string('user_id');
            $table->string('lang');
            $table->string('platform');
            $table->float('version');
            $table->string('name');
            $table->string('identifier');
            $table->string('fcm_token');
            $table->bigInteger('last_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_devices');
    }
}