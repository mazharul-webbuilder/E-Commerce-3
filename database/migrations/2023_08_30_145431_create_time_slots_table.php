<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time_slot_section_id');
            $table->unsignedBigInteger('ad_duration_id')->nullable();
            $table->string('time_slot_from');
            $table->string('time_slot_to');
            $table->timestamps();
            $table->foreign('time_slot_section_id')->references('id')->on('time_slot_sections')->onDelete('cascade');
            $table->foreign('ad_duration_id')->references('id')->on('ad_durations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_slots');
    }
}
