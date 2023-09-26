<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnRequestedByInFriendlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('friendlists', function (Blueprint $table) {
            $table->unsignedBigInteger('requested_by')->nullable();//who can bid
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('friendlists', function (Blueprint $table) {
            $table->dropColumn('requested_by');
        });
    }
}
