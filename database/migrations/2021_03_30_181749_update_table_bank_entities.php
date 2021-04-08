<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableBankEntities extends Migration
{
    /**
     * run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('bank_entities', function (blueprint $table) {
            $table->string('account_name')->nullable();
            $table->string('account_soles')->nullable();
            $table->string('account_interbank_soles')->nullable();
            $table->string('account_dollar')->nullable();
            $table->string('account_interbank_dollar')->nullable();
        });
    }

    /**
     * reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('bank_entities', function (blueprint $table) {
            $table->dropcolumn(['account_name', 'account_soles', 'account_interbank_soles', 'account_dollar', 'account_interbank_dollar']);
        });
    }
}
