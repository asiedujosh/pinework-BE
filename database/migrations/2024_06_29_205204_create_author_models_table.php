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
        Schema::create('author_models', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('fullName');
            $table->string('momoNumber');
            $table->string('otherNo')->nullable();
            $table->string('email')->unique();
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_models');
    }
};
