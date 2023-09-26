<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareHolderIncomeSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_holder_income_sources', function (Blueprint $table) {
            $table->id();
            $table->string('income_source_name');
            $table->float('commission',11,2);
            $table->tinyInteger('commission_type')->default(1)->comment('1=percent,2=flat');
            $table->enum('constrain_title',SHARE_HOLDER_INCOME_SOURCE);
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
        Schema::dropIfExists('share_holder_income_sources');
    }
}
