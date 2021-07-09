<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDanceoffTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danceoff_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danceoff_id');
            $table->integer('contestant_one_id');
            $table->integer('contestant_two_id');
            $table->integer('winner')->nullable();
            $table->foreign('danceoff_id')->references('id')->on('danceoffs')->onDelete('cascade');
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
        Schema::dropIfExists('danceoff_teams');
    }
}
