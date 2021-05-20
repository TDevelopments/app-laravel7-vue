<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('OrderDate');
            $table->dateTime('ShipDate')->nullable();
            $table->float('SalesTax', 8, 3)->default(0);
            $table->boolean('Delete')->default(0);
            $table->timestamps();
            $table->foreignId('sale_customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_state_order_id')->constrained();
            $table->foreignId('sale_payment_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_orders');
    }
}
