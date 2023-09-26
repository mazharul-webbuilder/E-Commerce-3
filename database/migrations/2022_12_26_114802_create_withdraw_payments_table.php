<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('image');
            $table->integer('priority')->unique();
            $table->tinyInteger('status')->default(0)->comment('0=active,1=inactive');
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
        Schema::dropIfExists('withdraw_payments');
    }
}
