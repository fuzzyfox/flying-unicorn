<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flags', function (Blueprint $table) {
            $table->uuid('id', 40);
            $table->string('name');
            $table->text('description');

            $table->timestamps();

            $table->primary('id');
        });

        Schema::create('flaggables', function (Blueprint $table) {
            $table->string('flaggable_type');
            $table->uuid('flaggable_id');
            $table->uuid('flag_id');
            $table->timestamp('flagged_at');
            $table->uuid('flagged_by')->nullable();

            $table->primary(['flaggable_type', 'flaggable_id', 'flag_id']);

            $table->foreign('flag_id')->references('id')->on('flags')
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
        Schema::dropIfExists('flaggables');
        Schema::dropIfExists('flags');
    }
}
