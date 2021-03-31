<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBankEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_entities', function (Blueprint $table) {
            $table->string('account_name')->nullable();
            $table->string('account_soles')->nullable();
            $table->string('account_interbank_soles')->nullable();
            $table->string('account_dollar')->nullable();
            $table->string('account_interbank_dollar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_entities', function (Blueprint $table) {
            //
        });
    }
}
