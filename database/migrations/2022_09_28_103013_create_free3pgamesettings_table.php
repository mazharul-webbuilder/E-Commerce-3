<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFree3pgamesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free3pgamesettings', function (Blueprint $table) {
            $table->id();
            $table->double('first_winner_multiply')->nullable();
            $table->double('second_winner_multiply')->nullable();
            $table->double('third_winner_multiply')->nullable();
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
        Schema::dropIfExists('free3pgamesettings');
    }
}
