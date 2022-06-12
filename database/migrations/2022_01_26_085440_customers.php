<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('customer_id',255)->primary();
            $table->string('store_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('address_id');
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
        Schema::dropIfExists('customers');
    }
}