<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('withdraw_payment_id');
            $table->string('account_number');
            $table->enum('account_type',['personal'])->default('personal');
            $table->tinyInteger('is_verify')->default(1)->comment('0=not verified,1=verified');
            $table->string('otp')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('withdraw_payment_id')->references('id')->on('withdraw_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_payment_methods');
    }
}
