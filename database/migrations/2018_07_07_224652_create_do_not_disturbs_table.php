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
            $table->uuid('id');
            $table->uuid('user_id');
            $table->timestamp('start_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('reason')->nullable();

            $table->primary('id');

            $table->timestamps();

            $table->unique(['user_id', 'start_time', 'end_time']);

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
