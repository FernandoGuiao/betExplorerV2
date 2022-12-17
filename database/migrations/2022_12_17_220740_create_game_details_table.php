<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');

            $table->tinyInteger('time');

            $table->tinyInteger('home_goal');
            $table->tinyInteger('guest_goal');

            $table->tinyInteger('home_corner');
            $table->tinyInteger('guest_corner');

            $table->tinyInteger('home_on_target');
            $table->tinyInteger('guest_on_target');

            $table->tinyInteger('home_off_target');
            $table->tinyInteger('guest_off_target');

            $table->tinyInteger('home_red');
            $table->tinyInteger('guest_red');

            $table->tinyInteger('home_yellow');
            $table->tinyInteger('guest_yellow');

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
        Schema::dropIfExists('game_details');
    }
};
