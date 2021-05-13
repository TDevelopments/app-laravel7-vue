<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['none', 'masculine','female', 'unisex'])->default('none')->nullable();
            $table->string('state')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'state',
                'postalCode',
                'country'
            ]);
        });
    }
}
