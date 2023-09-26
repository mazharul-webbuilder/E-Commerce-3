<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_durations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('per_ad_price',8,5);
            $table->tinyInteger('has_slot')->comment('0=has no time slot,1=has time slot');
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
        Schema::dropIfExists('ad_durations');
    }
}
