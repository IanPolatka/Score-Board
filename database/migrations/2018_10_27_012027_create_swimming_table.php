<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwimmingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swimming', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id');
            $table->integer('team_level');
            $table->date('date');
            $table->integer('scrimmage');
            $table->string('tournament_name')->nullable();
            $table->integer('team_id');
            $table->integer('time_id');
            $table->integer('host_id')->nullable();
            $table->string('boys_result')->nullable();
            $table->string('girls_result')->nullable();
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
        Schema::dropIfExists('swimming');
    }
}
