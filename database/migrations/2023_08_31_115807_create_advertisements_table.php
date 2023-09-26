<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('club_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('ad_duration_id');
            $table->unsignedBigInteger('time_slot_section_id')->nullable();
            $table->unsignedBigInteger('time_slot_id')->nullable();

            $table->integer('total_ad');
            $table->integer('total_day');
            $table->float('total_cost',11,4);
            $table->integer('ad_show_per_day');
            $table->integer('remain_ad')->nullable();
            $table->dateTime('ad_start_from')->nullable();
            $table->dateTime('ad_end_in')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0=on,1=off');
            $table->timestamps();

          //  $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
         //   $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
          //  $table->foreign('ad_duration_id')->references('id')->on('ad_durations')->onDelete('cascade');
           // $table->foreign('time_slot_section_id')->references('id')->on('time_slot_sections')->onDelete('cascade');
           // $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
