<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('category', ['cardio', 'strength', 'flexibility', 'sports', 'other'])->default('other');
            $table->unsignedInteger('duration_minutes');
            $table->unsignedInteger('calories_burned')->default(0);
            $table->text('notes')->nullable();
            $table->date('performed_on');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
