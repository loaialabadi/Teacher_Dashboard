<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('group_id');
            $table->date('date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('subject')->nullable();
            $table->string('description')->nullable(); // ✅ تمت إضافته هنا
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('appointments');
    }
};
