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
            $table->tinyInteger('min_diff_shoots')->nullable()->after('max_sum_shoots');
            $table->tinyInteger('max_diff_shoots')->nullable()->after('min_diff_shoots');

            $table->tinyInteger('second_half_min_diff_shoots')->nullable()->after('second_half_max_sum_shoots');
            $table->tinyInteger('second_half_max_diff_shoots')->nullable()->after('second_half_min_diff_shoots');

            $table->tinyInteger('min_diff_red')->nullable()->after('min_sum_red');
            $table->tinyInteger('max_diff_red')->nullable()->after('min_diff_red');

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
            $table->dropColumn('min_diff_red');
            $table->dropColumn('max_diff_red');
            $table->dropColumn('second_half_min_diff_shoots');
            $table->dropColumn('second_half_max_diff_shoots');
            $table->dropColumn('min_diff_shoots');
            $table->dropColumn('max_diff_shoots');
        });
    }
};
