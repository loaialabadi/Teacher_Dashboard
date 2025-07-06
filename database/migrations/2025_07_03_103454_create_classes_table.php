<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // اسم الفصل الدراسي، مثل "الفصل الأول"
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('classes');
    }
};
