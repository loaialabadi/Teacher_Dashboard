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


            $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('set null');

            $table->timestamps();


            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('groups');
    }
};
