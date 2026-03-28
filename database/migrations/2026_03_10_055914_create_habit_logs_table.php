<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('logged_at');
            $table->string('mood')->nullable(); // great, good, okay, bad
            $table->text('notes')->nullable();
            $table->timestamps();

            // Satu habit hanya bisa di-log 1x per hari
            $table->unique(['habit_id', 'logged_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};