<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStockRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_stock_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_product_id')->constrained()->onDelete('cascade');
            $table->bigInteger('Quantity');
            $table->foreignId('sale_product_status_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_business_location_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_customer_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_stock_records');
    }
}
