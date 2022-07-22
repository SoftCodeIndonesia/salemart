<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 255)->primary();
            $table->string('rules_id')->nullable();
            $table->string('username')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('email_is_verify')->nullable();
            $table->bigInteger('email_verify_at')->nullable();
            $table->string('email_verify_id')->nullable();
            $table->bigInteger('email_verify_id_expired')->nullable();
            $table->string('password');
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->bigInteger('is_actived')->nullable();
            $table->bigInteger('register_at')->nullable();


            // $table->foreign('rules_id')->references('rules_id')->on('rules');
        });

        
        // Schema::table('users', function (Blueprint $table) {
        //     $table->foreign('rules_id')->references('rules_id')->on('rules');
        // });
     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}