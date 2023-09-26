<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamond_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('total_diamond');
            $table->float('price');
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
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
        Schema::dropIfExists('diamond_packages');
    }
}
