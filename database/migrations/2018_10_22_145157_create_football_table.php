<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootballTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id');
            $table->integer('team_level');
            $table->date('date');
            $table->integer('scrimmage');
            $table->string('tournament_name')->nullable();
            $table->integer('away_team_id');
            $table->integer('home_team_id');
            $table->integer('time_id');
            $table->integer('district_game')->nullable();
            $table->integer('game_status')->nullable();
            $table->string('game_minute')->nullable();
            $table->string('game_second')->nullable();
            $table->integer('away_team_final_score')->nullable();
            $table->integer('home_team_final_score')->nullable();
            $table->integer('winning_team')->nullable();
            $table->integer('losing_team')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('football');
    }
}
