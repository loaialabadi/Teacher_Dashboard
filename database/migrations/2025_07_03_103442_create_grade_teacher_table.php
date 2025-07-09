<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
Schema::create('grade_teacher', function (Blueprint $table) {
    $table->id();

    $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
    $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');

    $table->timestamps();
    $table->unique(['teacher_id', 'grade_id']);
});

    }

    public function down(): void {
        Schema::dropIfExists('grade_teacher');
    }
};
