<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->string('product_transaction_id',255)->primary();
            $table->string('transaction_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transactions');
    }
}