<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolleyballScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volleyball_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('away_team_score')->unsigned()->nullable();
            $table->integer('home_team_score')->unsigned()->nullable();
            $table->integer('game_winner')->unsigned()->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
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
        Schema::dropIfExists('volleyball_scores');
    }
}
