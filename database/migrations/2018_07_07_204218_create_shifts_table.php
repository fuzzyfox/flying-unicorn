<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->uuid('location_id')->nullable();

            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->integer('min')->default(1);
            $table->integer('max')->nullable();
            $table->integer('desired')->default(2);

            $table->timestamp('start_time');
            $table->timestamp('end_time');

            $table->timestamps();

            $table->primary('id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
