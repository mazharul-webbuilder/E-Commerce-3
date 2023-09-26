<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToSavePaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('save_payment_methods', function (Blueprint $table) {
            $table->string('name')->nullable()->after('withdraw_payment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_payment_methods', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}
