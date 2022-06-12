<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->string('store_id',255)->primary();
            $table->string('user_id');
            $table->foreignId('address_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('logo_url')->nullable();
            $table->bigInteger('created_at')->nullable();
            $table->bigInteger('last_updated')->nullable();
            $table->string('created_by');

            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}