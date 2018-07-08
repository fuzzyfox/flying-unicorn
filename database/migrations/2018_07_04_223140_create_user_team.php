<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_team', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('team_id');
            $table->integer('weight')->nullable();

            $table->timestamp('approved')->nullable();
            $table->timestamp('rejected')->nullable();
            $table->text('rejected_reason')->nullable();

            $table->timestamps();

            $table->primary(['user_id', 'team_id']);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')
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
        Schema::dropIfExists('user_team');
    }
}
