<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UuidPksAndFks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->renameColumn('user_id', '_');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->uuid('user_id')->index()->nullable()->after('id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->dropColumn('_');
        });

        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->after('id');
            $table->unsignedInteger('client_id')->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade');
        });

        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->unsignedInteger('client_id')->change();

            $table->foreign('client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade');
        });

        Schema::table('oauth_refresh_tokens', function(Blueprint $table) {
            $table->foreign('access_token_id')
                ->references('id')->on('oauth_access_tokens')
                ->onDelete('cascade');
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->uuid('user_id')->after('id');
            $table->unsignedInteger('client_id')->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('client_id')
                ->references('id')->on('oauth_clients')
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
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['client_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->integer('user_id')->after('id');
        });

        Schema::table('oauth_refresh_tokens', function(Blueprint $table) {
            $table->dropForeign(['access_token_id']);
        });

        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });

        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['client_id']);

            $table->dropColumn('user_id');
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->integer('user_id')->index()->nullable()->after('id');
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropIndex(['user_id']);

            $table->dropColumn('user_id');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->integer('user_id')->index()->nullable()->after('id');
        });
    }
}
