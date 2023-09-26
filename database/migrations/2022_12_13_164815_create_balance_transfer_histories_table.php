<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BalanceTransferHistory;

class CreateBalanceTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("depart_from");
            $table->string('destination_to');
            $table->float('transfer_balance',11,2);
            $table->float('deduction_charge');
            $table->float('stored_balance')->comment('This balance is after deduction charge');
            $table->enum('constant_title',BalanceTransferHistory::balance_transfer_constant);
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
        Schema::dropIfExists('balance_transfer_histories');
    }
}
