<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sku')->unique();
            // $table->string('video')->nullable();
            $table->json('description')->nullable();
            $table->integer('magnifying')->default(1);
            $table->json('images')->nullable();
            $table->string('model');
            $table->string('slug')->unique();
            $table->json('colors')->nullable();
            $table->integer('stock');
            $table->integer('count')->default(0);
            $table->string('brand')->default('Sin marca');
            $table->float('price_sale', 8, 2)->nullable();
            $table->boolean('on_sale')->default(0);
            $table->timestamps();
            
            $table->float('price_unit', 8, 2);
            $table->float('price_group', 8, 2);
            $table->integer('quantity_group');
            $table->string('type_group');

            $table->foreignId('catalogue_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
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
