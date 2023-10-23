<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifyCodeToAffiliators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliators', function (Blueprint $table) {
            $table->string('verification_code')->nullable()->unique();
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliators', function (Blueprint $table) {
            $table->dropColumn('verification_code');
            $table->dropColumn('verified_at');
        });
    }
}
