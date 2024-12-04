<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->timestamps();
        });

        Schema::create('poll_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option');
            $table->timestamps();

            $table->unsignedInteger('poll_id');
            $table->foreign('poll_id')
                  ->references('id')
                  ->on('polls')
                  ->onDelete('CASCADE');
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable(false);
            $table->timestamps();

            $table->unsignedInteger('poll_id');
            $table->foreign('poll_id')
                  ->references('id')
                  ->on('polls')
                  ->onDelete('CASCADE');

            $table->unsignedInteger('option_id');
            $table->foreign('option_id')
                  ->references('id')
                  ->on('poll_options')
                  ->onDelete('CASCADE');

            $table->unique(['username', 'poll_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polls');
        Schema::dropIfExists('poll_options');
        Schema::dropIfExists('votes');
    }
}
