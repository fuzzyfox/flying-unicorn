<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_fields', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('key', 40);
            $table->string('type', 40);
            $table->string('entity');
            $table->string('validator')->default('nullable');
            $table->string('permissions_slug')->nullable();
            $table->json('default')->nullable();

            $table->string('label');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->uuid('created_by')->nullable();

            $table->primary('id');
            $table->unique(['key', 'type', 'entity']);

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null');
        });

        Schema::create('additional_field_values', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('additional_field_id');
            $table->uuid('entity_id');
            $table->json('value')->nullable();

            $table->primary('id');
            $table->unique(['additional_field_id', 'entity_id']);

            $table->foreign('additional_field_id')->references('id')->on('additional_fields')
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
        Schema::dropIfExists('additional_field_values');
        Schema::dropIfExists('additional_fields');
    }
}
