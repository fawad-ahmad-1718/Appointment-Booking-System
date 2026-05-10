<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_booked')->default(false);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->timestamps();

            // Prevent duplicate slots for same staff on same date/time
            $table->unique(['staff_id', 'service_id', 'date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
};
