<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('club_join_cost')->nullable()->comment('coin will be cut who will join club');
            $table->integer('controller_tournament_post_limit')->nullable()->comment('Every controller arrange this amount of tournament');
            $table->integer('sub_controller_tournament_post_limit')->nullable()->comment('Every sub controller arrange this amount of tournament');
            $table->float('club_join_referral_commission',11,2)->nullable()->comment("Club owner's referral will get this amount when any user wil join club ");
            $table->float('club_join_share_fund_commission',11,2)->nullable()->comment("This amount will be stored in share holder fund get this amount when any user wil join club ");
            $table->float('club_join_club_owner_commission',11,2)->nullable()->comment("Club owner will get this kind of amount when any user wil join club");
            $table->float('tournament_registration_admin_commission',11,2)->nullable()->comment("When user will register in any club owner's tournament admin will get this kind of amount");
            $table->float('tournament_registration_club_owner_commission',11,2)->nullable()->comment("When user will register in any club owner's tournament club owner will get this kind of amount");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_settings');
    }
}
