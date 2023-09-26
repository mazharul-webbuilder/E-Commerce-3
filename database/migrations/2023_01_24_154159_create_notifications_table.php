<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->unsignedBigInteger('gameround_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->enum('type',Notification::NOTIFICATION_TYPE)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=unseen,1=seen');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gameround_id')->references('id')->on('gamerounds')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
