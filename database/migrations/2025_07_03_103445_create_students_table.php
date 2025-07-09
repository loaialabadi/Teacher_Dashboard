<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();

            // المفتاح الأجنبي المرتبط بـ school_grades
            $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('cascade');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();  // ربط الطالب بالمعلم

            // المفاتيح الأجنبية الأخرى
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('students');
    }
};
