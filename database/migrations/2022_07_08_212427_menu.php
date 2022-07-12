<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Menu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->string('feature_id', 255)->primary();
            $table->string('parent_id', 255);
            $table->string('feature_code');
            $table->string('feature_name');
            $table->string('feature_description');
            $table->string('feature_icon_web');
            $table->string('feature_icon_desktop');
            $table->string('feature_icon_mobile');
            $table->string('feature_route');
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
        Schema::dropIfExists('features');
    }
}