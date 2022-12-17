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
        Schema::create('user_configs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->tinyInteger('min_time')->nullable();
            $table->tinyInteger('max_time')->nullable();

            $table->tinyInteger('min_sum_shoots')->nullable();
            $table->tinyInteger('max_sum_shoots')->nullable();

            $table->tinyInteger('min_sum_corners')->nullable();
            $table->tinyInteger('max_sum_corners')->nullable();

            $table->tinyInteger('min_sum_red')->nullable();
            $table->tinyInteger('max_sum_red')->nullable();

            $table->integer('activated_count');
            
            $table->boolean('status');

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
        Schema::dropIfExists('user_configs');
    }
};
