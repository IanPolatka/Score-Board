<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->nullable()->default(NULL);
            $table->integer('year_id')->nullable()->default(NULL);
            $table->integer('baseball_region')->nullable()->default(NULL);
            $table->integer('baseball_district')->nullable()->default(NULL);
            $table->integer('basketball_region')->nullable()->default(NULL);
            $table->integer('basketball_district')->nullable()->default(NULL);
            $table->integer('football_class')->nullable()->default(NULL);
            $table->integer('football_district')->nullable()->default(NULL);
            $table->integer('soccer_region')->nullable()->default(NULL);
            $table->integer('soccer_district')->nullable()->default(NULL);
            $table->integer('softball_region')->nullable()->default(NULL);
            $table->integer('softball_district')->nullable()->default(NULL);
            $table->integer('volleyball_region')->nullable()->default(NULL);
            $table->integer('volleyball_district')->nullable()->default(NULL);
            $table->integer('modified_by')->nullable()->default(NULL);
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
        Schema::dropIfExists('teams_meta');
    }
}
