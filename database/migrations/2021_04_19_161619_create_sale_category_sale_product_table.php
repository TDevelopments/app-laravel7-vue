<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleCategorySaleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_category_sale_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_category_id');
            $table->unsignedBigInteger('sale_product_id');
            $table->timestamps();
            $table->foreign('sale_category_id')
                ->references('id')
                ->on('sale_categories')
                ->onDelete('cascade');
            $table->foreign('sale_product_id')
                ->references('id')
                ->on('sale_products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_category_sale_product');
    }
}
