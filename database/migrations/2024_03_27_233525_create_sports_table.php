<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->binary('image');
            $table->binary('banner');
            $table->binary('icon');
            $table->integer(
                'exact_marker_points'
            );
            $table->integer(
                'points_winner_loser'
            );
            $table->integer(
                'tie_points'
            );
            $table->integer(
                'points_lost'
            );
            $table->integer(
                'participant_fee'
            );
            $table->integer(
                'platform_commission'
            );
            $table->integer(
                'status'
            );
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
        Schema::dropIfExists('sports');
    }
}
