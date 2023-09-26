<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OfferTournament;

class CreateOfferTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('required_position_name')->nullable();
            $table->integer('total_needed_position')->nullable();
            $table->integer('duration')->nullable()->comment('duration will be counted as day');
            $table->enum('constrain_title',OfferTournament::OFFER_TYPE)->unique()->nullable();
            $table->enum('duration_type',['fixed','open'])->nullable();
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
        Schema::dropIfExists('offer_tournaments');
    }
}
