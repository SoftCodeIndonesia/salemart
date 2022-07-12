<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StakeholderPermissionRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakeholder_permission_rules', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('permission_id')->foreignId('permission')->constrained('stakeholder_permission');
            $table->string('rules_id')->foreignId('rules_id')->constrained('rules');
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
        Schema::dropIfExists('stakeholder_permission_rules');
    }
}