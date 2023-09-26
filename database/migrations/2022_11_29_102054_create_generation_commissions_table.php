<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Generation_commission;

class CreateGenerationCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generation_commissions', function (Blueprint $table) {
            $table->id();
            $table->enum('generation_name',Generation_commission::generation_name)->unique();
            $table->float('commission',11,2)->comment('commission will be calculated as percent (%)');
            $table->enum('generation_level',Generation_commission::generation_level)->unique();
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
        Schema::dropIfExists('generation_commissions');
    }
}
