<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoastingMoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boasting_money', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('payment_id');
            $table->float('boasting_amount',11,2);
            $table->float('boasting_dollar',11,6);
            $table->string('image')->nullable();
            $table->string('transaction_number')->unique();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1=pending,2=processing,3=accept=4=reject');
            $table->timestamps();
           // $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boasting_money');
    }
}
