<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Province extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->integer('id', 2)->primary();
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
        Schema::dropIfExists('provinces');
    }
}