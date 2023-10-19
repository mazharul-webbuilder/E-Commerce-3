<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvidedCoinToProductAffiliateCommissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_affiliate_commissions', function (Blueprint $table) {
            $table->float("provided_coin",11,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_affiliate_commissions', function (Blueprint $table) {
            $table->dropColumn("provided_coin");
        });
    }
}
