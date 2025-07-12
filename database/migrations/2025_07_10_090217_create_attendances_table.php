<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('lecture_id'); // ربط الحضور بالمحاضرة
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('attendances');
    }
};
