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
        Schema::table('user_configs', function (Blueprint $table) {
            $table->tinyInteger('second_half_min_sum_shoots')->nullable()->after('min_sum_shoots');
            $table->tinyInteger('second_half_max_sum_shoots')->nullable()->after('max_sum_shoots');

            $table->tinyInteger('second_half_min_sum_corners')->nullable()->after('min_sum_corners');
            $table->tinyInteger('second_half_max_sum_corners')->nullable()->after('max_sum_corners');

            $table->tinyInteger('second_half_min_sum_red')->nullable()->after('min_sum_red');
            $table->tinyInteger('second_half_max_sum_red')->nullable()->after('max_sum_red');

            $table->tinyInteger('second_half_min_sum_goals')->nullable()->after('min_sum_goals');
            $table->tinyInteger('second_half_max_sum_goals')->nullable()->after('max_sum_goals');

            $table->tinyInteger('second_half_min_sum_shoots_on_target')->nullable()->after('min_sum_shoots_on_target');
            $table->tinyInteger('second_half_max_sum_shoots_on_target')->nullable()->after('max_sum_shoots_on_target');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_configs', function (Blueprint $table) {
            $table->dropColumn('second_half_min_sum_shoots');
            $table->dropColumn('second_half_max_sum_shoots');
            $table->dropColumn('second_half_min_sum_corners');
            $table->dropColumn('second_half_max_sum_corners');
            $table->dropColumn('second_half_min_sum_red');
            $table->dropColumn('second_half_max_sum_red');
            $table->dropColumn('second_half_min_sum_goals');
            $table->dropColumn('second_half_max_sum_goals');
            $table->dropColumn('second_half_min_sum_shoots_on_target');
            $table->dropColumn('second_half_max_sum_shoots_on_target');
        });
    }
};
