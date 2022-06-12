<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->string('address_id', 255)->primary();
            $table->integer('province_id');
            $table->string('province_name');
            $table->integer('city_id');
            $table->string('city_name');
            $table->text('address_detail');
            $table->bigInteger('created_at');
            $table->bigInteger('last_updated');
            $table->string('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}