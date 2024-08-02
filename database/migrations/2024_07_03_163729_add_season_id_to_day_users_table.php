<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeasonIdToDayUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_users', function (Blueprint $table) {
            $table->foreignId('season_id')->nullable()->constrained('seasons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_users', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
    }
}
