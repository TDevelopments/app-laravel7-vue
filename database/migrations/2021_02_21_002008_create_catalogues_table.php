<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(0);
            $table->enum('coin', ['soles', 'dolares']);
            $table->dateTime('quota_date');
            $table->float('quota_price', 8, 2);
            $table->float('minimum_investment', 8, 2);
            $table->float('first_payment', 8, 2);
            $table->dateTime('date_first_payment');
            $table->float('second_payment', 8, 2);
            $table->dateTime('date_second_payment');
            // $table->json('meta');
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
        Schema::dropIfExists('catalogues');
    }
}
