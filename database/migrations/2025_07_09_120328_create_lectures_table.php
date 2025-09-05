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
    Schema::create('lectures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('group_id')->constrained()->onDelete('cascade'); // مجموعة المحاضرة
        $table->foreignId('teacher_id')->constrained()->onDelete('cascade'); // المعلم
        $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // المادة
        $table->string('title');
        $table->enum('day_of_week', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
        $table->text('description')->nullable();
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
