<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_shift', function (Blueprint $table) {
            $table->uuid('team_id');
            $table->uuid('shift_id');

            $table->integer('min')->default(1);
            $table->integer('max')->nullable();
            $table->integer('desired')->default(2);

            $table->timestamps();

            $table->primary(['team_id', 'shift_id']);

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')
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
        Schema::dropIfExists('team_shift');
    }
}
