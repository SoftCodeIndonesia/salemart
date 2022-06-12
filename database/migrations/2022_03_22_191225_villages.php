<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Villages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('district_id');
            $table->string('name', 255);
            $table->string('alt_name', 255);
            $table->point('latitude');
            $table->point('longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villages');
    }
}