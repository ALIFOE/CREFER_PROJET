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
        // Drop the attendances table if it exists and recreate it properly
        Schema::dropIfExists('attendances');
        
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->string('student_id');
            $table->unsignedBigInteger('course_id');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'excused'])->default('absent');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');

            // Indexes
            $table->index(['student_id', 'course_id']);
            $table->index('attendance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
