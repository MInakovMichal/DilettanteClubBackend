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
        Schema::table('room_questions', function (Blueprint $table) {
            $table->foreign('room_id')->on('rooms')->references('id');
            $table->foreign('question_id')->on('questions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_questions', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['question_id']);
        });
    }
};
