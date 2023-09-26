<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryChargeInProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('delivery_charge_in_dhaka',11,2)->nullable();
            $table->float('delivery_charge_out_dhaka',11,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('delivery_charge_in_dhaka');
            $table->dropColumn('delivery_charge_out_dhaka');
        });
    }
}
