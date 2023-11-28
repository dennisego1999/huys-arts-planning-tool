<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dance_lessons', static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignId('teacher_id')->constrained('users', 'id')->onDelete('cascade');
            $table->json('subject');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dance_lessons');
    }
};
