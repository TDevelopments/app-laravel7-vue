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
            $table->string('Slug')->unique();
            $table->string('ProductName');
            $table->text('ProductDescription');
            $table->bigInteger('QuantityPerUnit')->default(1);
            $table->float('UnitPrice', 8, 3);
            $table->float('SellingPrice', 8, 3);
            $table->boolean('AvailableSize')->default(0);
            $table->boolean('AvailableColors')->default(0);
            $table->boolean('AvailableGender')->default(0);
            $table->json('Size')->nullable();
            $table->json('Color')->nullable();
            $table->string('Gender')->default('Ninguno')->nullable();
            $table->float('Discount', 8, 3)->nullable();
            $table->float('UnitWeight', 8, 3)->nullable();
            // $table->string('UnitMetric')->default('none')->nullable();
            $table->bigInteger('UnitsOnOrder')->default(0);
            // $table->bigInteger('UnitsInStock')->default(0);
            $table->boolean('ProductAvailable')->default(0);
            $table->boolean('DiscountAvailable')->default(0);
            /* $table->json('Picture')->nullable(); */
            $table->timestamps();
            $table->foreignId('sale_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_sub_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('sale_brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_product_unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_product_type_id')->constrained()->onDelete('cascade');
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
