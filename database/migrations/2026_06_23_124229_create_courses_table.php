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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('tag'); // e.g., 'yoruba', 'universal'
            $table->json('langs'); // e.g., ['EN', 'YO']
            $table->integer('modules_count')->default(0);
            $table->integer('students_count')->default(0);
            $table->json('culture_items')->nullable(); // e.g., {"yoruba": 64}
            $table->integer('avg_completion')->default(0); // e.g., 64
            $table->string('status')->default('Draft'); // 'Published', 'Draft'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
