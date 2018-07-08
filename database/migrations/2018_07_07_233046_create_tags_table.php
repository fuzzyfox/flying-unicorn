<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 40);
            $table->text('description')->nullable();

            $table->primary('id');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->uuid('tag_id');
            $table->string('taggable_type');
            $table->uuid('taggable_id');

            $table->primary(['tag_id', 'taggable_type', 'taggable_id']);

            $table->foreign('tag_id')->references('id')->on('tags')
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
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
}
