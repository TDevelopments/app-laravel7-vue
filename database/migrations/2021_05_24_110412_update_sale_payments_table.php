<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            $table->foreignId('sale_order_id')->nullable()->constrained()->onDelete('cascade');
            $table->renameColumn('Picture', 'PicturePath');
        });
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->dropForeign(['sale_payment_id']);
            $table->dropColumn(['sale_payment_id']);
            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_payments', function (Blueprint $table) {
            $table->dropForeign(['sale_order_id']);
            $table->dropColumn(['sale_order_id']);
        });
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id']);
        });
    }
}
