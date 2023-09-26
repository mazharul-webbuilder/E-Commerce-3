<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_one')->nullable();//who can bid
            $table->foreign('user_id_one')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id_two')->nullable();//who can bid
            $table->foreign('user_id_two')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->default(0)->comment('0=pending,1=Running,2=Complete');
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
        Schema::dropIfExists('friendlists');
    }
}
