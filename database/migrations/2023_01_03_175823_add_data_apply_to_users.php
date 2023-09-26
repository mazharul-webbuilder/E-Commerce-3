<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataApplyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('applicable_user')->default(1)->comment('1=applicable ,0=not applicable');
            $table->tinyInteger('apply_data')->default(0)->comment('1=applied ,0=not applied');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('applicable_user');
            $table->dropColumn('apply_data');
        });
    }
}
