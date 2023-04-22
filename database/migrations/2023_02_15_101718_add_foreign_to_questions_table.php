<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('answer_id')->on('answers')->references('id');
            $table->foreign('language_id')->on('languages')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('answer_id');
            $table->dropForeign('language_id');
        });
    }
};
