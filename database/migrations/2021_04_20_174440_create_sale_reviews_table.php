<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_product_id')->constrained()->onDelete('cascade');
            $table->string('NameUser');
            $table->text('Review');
            $table->double('Star');
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
        Schema::dropIfExists('sale_reviews');
    }
}
