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
Schema::create('quiz_results', function (Blueprint $table) {
    $table->id();
    $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->integer('score')->nullable(); // الدرجة
    $table->text('note')->nullable();    // ملاحظات من المدرس
    $table->timestamps();

    $table->unique(['quiz_id', 'student_id']); // كل طالب له نتيجة واحدة في الاختبار
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
