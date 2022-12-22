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
        Schema::table('game_user_configs', function (Blueprint $table) {
            $table->dropForeign('game_user_configs_user_config_id_foreign');
            $table->foreign('user_config_id')
            ->references('id')->on('user_configs')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_user_configs', function (Blueprint $table) {
            //
        });
    }
};
