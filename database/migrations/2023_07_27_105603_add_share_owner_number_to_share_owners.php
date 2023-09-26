<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShareOwnerNumberToShareOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('share_owners', function (Blueprint $table) {
            $table->string('share_owner_number')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('share_owners', function (Blueprint $table) {
            $table->dropColumn('share_owner_number');
        });
    }
}
