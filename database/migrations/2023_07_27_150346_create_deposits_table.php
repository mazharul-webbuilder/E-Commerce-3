<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('share_owner_id');
            $table->unsignedBigInteger('payment_id');
            $table->float('deposit_amount',11,2);
            $table->string('transaction_number')->unique();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default('1')->comment('1=pending,2=processing,3=accept=4=reject');
            $table->timestamps();
            $table->foreign('share_owner_id')->references('id')->on('share_owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
