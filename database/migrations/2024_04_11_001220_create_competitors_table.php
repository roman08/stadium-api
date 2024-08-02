<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('second_surname');
            $table->date('birth_date');
            $table->string('phone');
            $table->binary('profile_img');
            $table->string('email');
            $table->string('password');
            $table->integer('bank_id');
            $table->string('bank_account');
            $table->integer('account_type_id');
            $table->string('observations');
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
        Schema::dropIfExists('competitors');
    }
}
