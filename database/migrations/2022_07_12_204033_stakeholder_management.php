<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StakeholderManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakeholder_feature', function (Blueprint $table) {
            $table->id('feature_id');
            $table->bigInteger('parent_id');
            $table->string('feature_code');
            $table->string('feature_name');
            $table->string('feature_description');
            $table->string('feature_icon');
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
        Schema::dropIfExists('stakeholder_feature');
    }
}