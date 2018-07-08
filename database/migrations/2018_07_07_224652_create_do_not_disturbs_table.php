<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoNotDisturbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('do_not_disturbs', function (Blueprint $table) {
            $table->uuid('user_id');

            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->text('reason')->nullable();

            $table->timestamps();

            $table->primary(['user_id', 'start_time', 'end_time']);

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('do_not_disturbs');
    }
}
