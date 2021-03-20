<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('sku')->unique();
            $table->json('description')->nullable();
            $table->json('images')->nullable();
            $table->string('model')->unique();
            $table->string('slug')->unique();
            $table->json('colors')->nullable();
            $table->integer('stock');
            $table->integer('count')->default(0);
            $table->string('brand')->default('Sin marca');
            $table->float('price_sale', 8, 2)->nullable();
            $table->boolean('on_sale')->default(0);
            $table->timestamps();
            
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
        Schema::dropIfExists('product_ranges');
    }
}
