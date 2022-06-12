<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_info', function (Blueprint $table) {
            $table->string('user_info_id',255)->primary();
            $table->string('user_id');
            $table->bigInteger('is_actived')->nullable();
            $table->bigInteger('active_at')->nullable();
            $table->bigInteger('last_actived')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_info');
    }
}