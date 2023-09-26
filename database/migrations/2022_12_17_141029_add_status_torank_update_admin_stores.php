<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusTorankUpdateAdminStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rank_update_admin_stores', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('0=invalid,1=valid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rank_update_admin_stores', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
