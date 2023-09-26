<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareHolderFundHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_holder_fund_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_source_id');
            $table->float('commission_amount');
            $table->float('commission_based_on')->nullable();
            $table->enum('commission_source',SHARE_HOLDER_INCOME_SOURCE);
            $table->timestamps();
            $table->foreign('income_source_id')->references('id')->on('share_holder_income_sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_holder_fund_histories');
    }
}
