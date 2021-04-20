<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->string('Sku')->unique();
            $table->string('slug')->unique();
            $table->string('ProductName');
            $table->text('ProductDescription');
            $table->bigInteger('QuantityPerUnit');
            $table->float('UnitPrice', 8, 3);
            $table->boolean('AvailableSize')->default(0);
            $table->boolean('AvailableColors')->default(0);
            $table->boolean('AvailableGender')->default(0);
            $table->json('Size')->nullable();
            $table->json('Color')->nullable();
            $table->string('Gender')->default('none')->nullable();
            $table->float('Discount', 8, 3);
            $table->float('UnitWeight', 8, 3)->nullable();
            $table->string('UnitMetric')->default('none')->nullable();
            $table->bigInteger('UnitsOnOrder')->default(0);
            $table->bigInteger('UnitsInStock')->default(0);
            $table->boolean('ProductAvailable')->default(0);
            $table->boolean('DiscountAvailable')->default(0);
            $table->json('Picture')->nullable();
            $table->bigInteger('Ranking')->default(0);
            $table->timestamps();
            $table->foreignId('sale_category_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_products');
    }
}
