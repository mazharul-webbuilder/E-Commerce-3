<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_savings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('withdraw_history_id');
            $table->float('saving_amount',11,2);
            $table->tinyInteger('status')->default(0)->comment('0=valid,1=invalid');
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
        Schema::dropIfExists('withdraw_savings');
    }
}
