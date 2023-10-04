<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAffiliateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->cascadeOnDelete('products');
            $table->float('affiliate_commission',11,2);
            $table->float('company_commission',11,2);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_affiliate_commissions');
    }
}
