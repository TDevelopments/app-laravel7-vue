<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSaleStockRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_stock_records', function (Blueprint $table) {
            $table->string('Size')->nullable();
            $table->string('Color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_stock_records', function (Blueprint $table) {
            $table->dropColumn(['Size', 'Color']);
        });
    }
}
