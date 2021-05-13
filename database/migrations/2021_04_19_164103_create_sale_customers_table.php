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
            $table->string('FullName');
            $table->string('Dni')->unitque();
            $table->string('Address1')->nullable();
            $table->string('Address2')->nullable();
            $table->string('City')->nullable();
            $table->string('State')->nullable();
            $table->string('PostalCode')->nullable();
            $table->string('Country')->nullable();
            $table->string('Phone');
            $table->string('Email')->nullable();
            $table->string('ShipAddress')->nullable();
            $table->string('ShipCity')->nullable();
            $table->string('ShipRegion')->nullable();
            $table->string('ShipPostalCode')->nullable();
            $table->string('ShipCountry')->nullable();
            $table->string('BillingAddress')->nullable();
            $table->string('BillingCity')->nullable();
            $table->string('BillingRegion')->nullable();
            $table->string('BillingPostalCode')->nullable();
            $table->string('BillingCountry')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
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
