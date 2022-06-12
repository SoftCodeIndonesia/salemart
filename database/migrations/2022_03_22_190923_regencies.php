<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Regencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regencies', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id');
            $table->string('name', 255);
            $table->string('alt_name', 255);
            $table->point('latitude');
            $table->point('longitude');
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
        Schema::dropIfExists('regencies');
    }
}