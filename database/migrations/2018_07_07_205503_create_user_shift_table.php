<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shift', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('shift_id');

            // confirmed flags user acknowlegement of the shift
            $table->timestamp('confirmed')->nullable();
            // approved flags leader acknowlegemet of the shift
            $table->timestamp('approved')->nullable();
            $table->uuid('approved_by')->nullable();

            $table->timestamp('rejected')->nullable();
            $table->uuid('rejected_by')->nullable();
            $table->text('rejected_reason')->nullable();

            // checkin is when they started their shift
            $table->timestamp('checkin')->nullable();
            $table->uuid('checkin_by')->nullable();

            // checkout exists for if someone leaves shift early
            $table->timestamp('checkout')->nullable();
            $table->uuid('checkout_by')->nullable();

            // verify user on shift
            $table->timestamp('verified')->nullable();
            $table->uuid('verified_by')->nullable();

            $table->timestamps();

            $table->primary(['user_id', 'shift_id']);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')
                ->onDelete('cascade');

            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('checkin_by')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('checkout_by')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('users')
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
        Schema::dropIfExists('user_shift');
    }
}
