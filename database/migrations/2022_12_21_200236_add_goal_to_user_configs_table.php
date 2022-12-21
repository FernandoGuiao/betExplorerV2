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
            $table->string('name')->nullable()->after('user_id');
            $table->tinyInteger('min_sum_goals')->nullable()->after('max_time');
            $table->tinyInteger('max_sum_goals')->nullable()->after('min_sum_goals');
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
            $table->dropColumn('name');
            $table->dropColumn('min_sum_goals');
            $table->dropColumn('max_sum_goals');
        });
    }
};
