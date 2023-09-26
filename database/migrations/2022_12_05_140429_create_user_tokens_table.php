<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserToken;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('previous_rank_id')->nullable();
            $table->unsignedBigInteger('current_rank_id')->nullable();
            $table->unsignedBigInteger('withdrawal_id')->nullable();
            $table->string('token_number')->unique();
            $table->enum('getting_source',UserToken::getting_source);
            $table->enum('type',UserToken::token_type);
            $table->tinyInteger('status')->default(1)->comment('1=valid,0=invalid');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('previous_rank_id')->references('id')->on('ranks')->onDelete('cascade');
            $table->foreign('current_rank_id')->references('id')->on('ranks')->onDelete('cascade');
            $table->foreign('withdrawal_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_tokens');
    }
}
