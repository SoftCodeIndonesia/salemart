<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserHolderPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_holder_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->foreignId('id')->constrained('stakeholder_permission_rules');
            $table->string('user_id')->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('user_holder_permission');
    }
}