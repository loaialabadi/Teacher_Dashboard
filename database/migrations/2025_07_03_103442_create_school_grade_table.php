<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('school_grades', function (Blueprint $table) { // تصحيح اسم الجدول والتابع function
            $table->id();
            $table->string('name');  // اسم الفصل الدراسي، مثل "الفصل الأول"
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('school_grades'); // تصحيح اسم الجدول للحذف
    }
};
