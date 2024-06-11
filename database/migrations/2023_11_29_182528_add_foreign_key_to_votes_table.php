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
        Schema::table('votes', function (Blueprint $table) {
             // Add foreign key constraint for user_id
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
             // Add foreign key constraint for question_id
             $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
              // Remove the foreign key constraint for user_id
              $table->dropForeign(['user_id']);
            
              // Remove the foreign key constraint for question_id
              $table->dropForeign(['question_id']);
        });
    }
};
