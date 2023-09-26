<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('playerid')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('max_hit')->default(0);
            $table->string('country')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('otp')->nullable();
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->double('playcoin')->default(0);
            $table->double('shareholder_fund')->default(0);
            $table->double('marketing_balance')->default(0);
            $table->double('recovery_fund')->default(0);
            $table->double('crypto_asset')->default(0);
            $table->double('paid_diamond')->default(0);
            $table->double('paid_coin')->default(0);
            $table->double('free_coin')->default(0);
            $table->double('free_diamond')->default(0);
            $table->double('win_balance')->default(0);
            $table->double('max_win')->default(0);
            $table->double('max_loos')->default(0);
            $table->integer('refer_code')->default(0);
            $table->integer('used_reffer_code')->default(0);
            $table->timestamp('otp_verified_at')->nullable();
            $table->date('dob')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
