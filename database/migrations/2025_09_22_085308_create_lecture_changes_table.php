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
    Schema::create('lecture_changes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lecture_id')->constrained('lectures')->onDelete('cascade');
        $table->date('old_date');
        $table->time('old_start_time');
        $table->time('old_end_time');
        $table->date('new_date')->nullable();
        $table->time('new_start_time')->nullable();
        $table->time('new_end_time')->nullable();
        $table->string('reason')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_changes');
    }
};
