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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->year('year'); // السنة
            $table->enum('month', [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ]);
            $table->boolean('is_paid')->default(false); // هل مدفوع أم لا
            $table->date('paid_at')->nullable(); // تاريخ الدفع
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
