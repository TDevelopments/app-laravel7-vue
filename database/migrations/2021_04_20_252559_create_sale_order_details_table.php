<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_details', function (Blueprint $table) {
            $table->id();
            $table->float('Price', 8, 3);
            $table->bigInteger('Quantity');
            $table->string('ProductSku');
            $table->float('Discount', 8, 3)->nullable();
            $table->json('Size')->nullable();
            $table->json('Color')->nullable();
            $table->float('Total', 8, 3);
            $table->dateTime('ShipDate')->nullable();
            $table->timestamps();
            $table->foreignId('sale_order_id')->constrained();
            $table->foreignId('sale_product_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_order_details');
    }
}
