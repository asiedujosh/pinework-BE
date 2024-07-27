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
        Schema::create('book_models', function (Blueprint $table) {
            $table->id();
            $table->string('bookName');
            $table->string('bookType');
            $table->string('class');
            $table->longText('description');
            $table->string('authorId');
            $table->longText('coverImage');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_models');
    }
};
