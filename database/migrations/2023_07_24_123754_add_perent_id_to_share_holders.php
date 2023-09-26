<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerentIdToShareHolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_holders', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('share_holders', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
