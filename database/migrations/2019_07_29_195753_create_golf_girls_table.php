<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGolfGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('golf_girls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id');
            $table->integer('team_level');
            $table->date('date');
            $table->string('tournament_name')->nullable();
            $table->integer('away_team_id');
            $table->integer('home_team_id');
            $table->integer('time_id');
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
        Schema::dropIfExists('golf_girls');
    }
}
