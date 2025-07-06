<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('name');  // اسم المجموعة
            $table->unsignedBigInteger('grade_id')->nullable();  // الفصل الدراسي إن وُجد
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('classes')->onDelete('set null');
        });
    }

    public function down() {
        Schema::dropIfExists('groups');
    }
};
