<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country_name');
            $table->string('currency_symbol');
            $table->string('currency_code');
            $table->float('convert_to_bdt',11,4)->nullable();
            $table->float('convert_to_usd',11,4)->nullable();
            $table->float('convert_to_inr',11,4)->nullable();
            $table->tinyInteger('is_default')->comment('1=default,0=not default');
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
        Schema::dropIfExists('currencies');
    }
}
