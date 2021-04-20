<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_customers', function (Blueprint $table) {
            $table->id();
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Address1');
            $table->string('Address2')->nullable();
            $table->string('City');
            $table->string('State');
            $table->bigInteger('PostalCode');
            $table->string('Country');
            $table->string('Phone');
            $table->string('Email');
            $table->string('ShipAddress');
            $table->string('ShipCity');
            $table->string('ShipRegion');
            $table->bigInteger('ShipPostalCode');
            $table->string('ShipCountry');
            $table->string('BillingAddress');
            $table->string('BillingCity');
            $table->string('BillingRegion');
            $table->bigInteger('BillingPostalCode');
            $table->string('BillingCountry');
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_customers');
    }
}
