<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSellerUserRankUpgradeRequireProductToAffiliateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate_settings', function (Blueprint $table) {
            $table->integer('seller_user_rank_upgrade_require_product')->nullable()->after('share_holder_commission')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_settings', function (Blueprint $table) {
            $table->dropColumn('seller_user_rank_upgrade_require_product');
        });
    }
}
