<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeShareOwnerIdCoinEarninHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coin_earning_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('share_owner_id')->nullable();
            $table->enum('type',['user','share'])->nullable()->default('user');
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
        Schema::table('coin_earning_histories', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('share_owner_id');
        });
    }
}
