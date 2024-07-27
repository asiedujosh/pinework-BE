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
        Schema::create('question_models', function (Blueprint $table) {
            $table->id();
            $table->string('bookId');
            $table->string('pageId');
            $table->string('authorId');
            $table->string('questionNo');
            $table->string('question');
            $table->string('questionHint')->nullable();
            $table->string('options');
            $table->string('answer');
            $table->longText('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_models');
    }
};
