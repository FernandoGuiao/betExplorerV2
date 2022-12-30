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
            $table->tinyInteger('min_sum_shoots_on_target')->nullable()->after('max_sum_shoots');
            $table->tinyInteger('max_sum_shoots_on_target')->nullable()->after('min_sum_shoots_on_target');
            $table->tinyInteger('min_diff_goals')->nullable()->after('max_sum_goals');
            $table->tinyInteger('max_diff_goals')->nullable()->after('min_diff_goals');
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
            $table->dropColumn('min_sum_shoots_on_target');
            $table->dropColumn('max_sum_shoots_on_target');
            $table->dropColumn('min_diff_goals');
            $table->dropColumn('max_diff_goals');
        });
    }
};
