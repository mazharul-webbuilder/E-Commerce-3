<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewShareNumberToShareHolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_holders', function (Blueprint $table) {
            $table->string('share_number')->unique()->nullable()->after('share_purchase_price');
            $table->enum('share_type',['purchase','transfer','admin'])->nullable()->after('share_number');
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
            $table->dropColumn('share_number');
            $table->dropColumn('share_type');
        });
    }
}
