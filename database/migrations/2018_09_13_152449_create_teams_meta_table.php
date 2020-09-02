<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('team_id')->nullable()->default(null);
            $table->integer('year_id')->nullable()->default(null);
            $table->integer('baseball_region')->nullable()->default(null);
            $table->integer('baseball_district')->nullable()->default(null);
            $table->integer('basketball_region')->nullable()->default(null);
            $table->integer('basketball_district')->nullable()->default(null);
            $table->integer('football_class')->nullable()->default(null);
            $table->integer('football_district')->nullable()->default(null);
            $table->integer('soccer_region')->nullable()->default(null);
            $table->integer('soccer_district')->nullable()->default(null);
            $table->integer('softball_region')->nullable()->default(null);
            $table->integer('softball_district')->nullable()->default(null);
            $table->integer('volleyball_region')->nullable()->default(null);
            $table->integer('volleyball_district')->nullable()->default(null);
            $table->integer('modified_by')->nullable()->default(null);
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
