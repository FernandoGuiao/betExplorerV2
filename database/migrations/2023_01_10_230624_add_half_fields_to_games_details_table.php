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
        Schema::table('game_details', function (Blueprint $table) {
            $table->tinyInteger('first_half_home_goal')->nullable()->after('home_goal');
            $table->tinyInteger('first_half_guest_goal')->nullable()->after('guest_goal');

            $table->tinyInteger('first_half_home_corner')->nullable()->after('home_corner');
            $table->tinyInteger('first_half_guest_corner')->nullable()->after('guest_corner');

            $table->tinyInteger('first_half_home_on_target')->nullable()->after('home_on_target');
            $table->tinyInteger('first_half_guest_on_target')->nullable()->after('guest_on_target');

            $table->tinyInteger('first_half_home_off_target')->nullable()->after('home_off_target');
            $table->tinyInteger('first_half_guest_off_target')->nullable()->after('guest_off_target');

            $table->tinyInteger('first_half_home_red')->nullable()->after('home_red');
            $table->tinyInteger('first_half_guest_red')->nullable()->after('guest_red');

            $table->tinyInteger('first_half_home_yellow')->nullable()->after('home_yellow');
            $table->tinyInteger('first_half_guest_yellow')->nullable()->after('guest_yellow');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_details', function (Blueprint $table) {
            $table->dropColumn('first_half_home_goal');
            $table->dropColumn('first_half_guest_goal');
            $table->dropColumn('first_half_home_corner');
            $table->dropColumn('first_half_guest_corner');
            $table->dropColumn('first_half_home_on_target');
            $table->dropColumn('first_half_guest_on_target');
            $table->dropColumn('first_half_home_off_target');
            $table->dropColumn('first_half_guest_off_target');
            $table->dropColumn('first_half_home_red');
            $table->dropColumn('first_half_guest_red');
            $table->dropColumn('first_half_home_yellow');
            $table->dropColumn('first_half_guest_yellow');
        });
    }
};
