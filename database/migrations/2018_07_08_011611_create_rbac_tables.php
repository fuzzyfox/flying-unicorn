<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRbacTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->primary('id');
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('slug');
            $table->string('entity_type');
            $table->uuid('entity_id');
            $table->uuid('assigned_by')->nullable();

            $table->timestamps();

            $table->primary('id');
            $table->unique(['slug', 'entity_type', 'entity_id']);
            $table->foreign('assigned_by')->references('id')->on('users')
                ->onDelete('set null');
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('role_id');
            $table->uuid('assigned_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary(['user_id', 'role_id', 'created_at']);
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')
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
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
}
