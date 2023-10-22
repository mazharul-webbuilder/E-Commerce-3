<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCompanyCommissionToAffiliateCommissionIntoProductCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_commissions', function (Blueprint $table) {
            $table->renameColumn(from: 'company_commission', to:  'affiliate_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_commissions', function (Blueprint $table) {

        });
    }
}
