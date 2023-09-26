<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->unsignedBigInteger('rank_id')->nullable()->default(null);
            $table->tinyInteger('commission_block')->default(1)->comment('0=block,1=unblock');
            $table->tinyInteger('diamond_purchase')->default(0)->comment('0=not purchase yet,1=already purchased');
            $table->tinyInteger('vip_member')->default(0)->comment('0=not vip member,1=vip member');
            $table->tinyInteger('diamond_partner')->default(0)->comment('0=not diamond partner,1=diamond partner');
            $table->float('hold_coin')->nullable()->default(null)->comment('if any user delay to update rank commission coin will be stored here');

        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
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
            $table->dropForeign("parent_id");
            $table->dropForeign('rank_id');
            $table->dropColumn('commission_block');
            $table->dropColumn('diamond_purchase');
            $table->dropColumn('vip_member');
            $table->dropColumn('diamond_partner');
            $table->dropColumn('hold_coin');
        });
    }
}
