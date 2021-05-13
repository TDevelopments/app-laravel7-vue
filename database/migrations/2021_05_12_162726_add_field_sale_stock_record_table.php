<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSaleStockRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_stock_records', function (Blueprint $table) {
            $table->foreignId('order_detail_id')->nullable()->constrained()->onDelete('cascade');
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
            $table->dropForeign(['order_detail_id']);
            $table->dropColumn(['order_detail_id']);
        });
    }
}
