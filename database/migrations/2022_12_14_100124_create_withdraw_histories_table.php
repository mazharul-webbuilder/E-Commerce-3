<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('withdraw_balance',11,2);
            $table->float('user_received_balance',11,2);
            $table->float('charge',11,2)->nullable();
            $table->enum('balance_send_type',PAYMENT_TYPE);
            $table->text('bank_detail')->nullable();
            $table->text('mobile_account_detail')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=pending,2=processing,3=accept,4=reject');
            $table->text('user_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraw_histories');
    }
}
