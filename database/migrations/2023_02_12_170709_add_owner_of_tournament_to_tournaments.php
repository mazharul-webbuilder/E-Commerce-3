<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tournament;

class AddOwnerOfTournamentToTournaments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {

            $table->unsignedBigInteger('club_owner_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('tournament_owner',Tournament::TOURNAMENT_OWNER)->nullable();
            $table->foreign('club_owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {

           $table->dropColumn('club_owner_id');
            $table->dropColumn('admin_id');
            $table->dropColumn('tournament_owner');

        });
    }
}
