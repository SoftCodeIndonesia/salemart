<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id',255)->primary();
            $table->string('product_code');
            $table->string('store_id');
            $table->string('category_id');
            $table->string('name');
            $table->string('image_url');
            $table->bigInteger('quantity');
            $table->double('buy_price');
            $table->double('selling_price');
            $table->text('product_detail');
            $table->bigInteger('is_active');
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
        Schema::dropIfExists('products');
    }
}