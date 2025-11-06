<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add project_id to mentoring table
        Schema::table('mentoring', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('mentee');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        // Add project_id to tasks table
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('mentee');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        // Add project_id to documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('mentee');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        // Add project_id to meetings table
        Schema::table('meetings', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('mentee');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        // Add project_id to chats table
        Schema::table('chats', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('mentee');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('mentoring', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
};
