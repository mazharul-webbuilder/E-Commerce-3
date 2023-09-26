<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReferralBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_referral_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->comment('whose referral code has been used');
            $table->unsignedBigInteger('child_id')->comment('who has used referral code');
            $table->float('reward');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_referral_bonuses');
    }
}
