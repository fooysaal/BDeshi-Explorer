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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('organizer');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('participants')->default(0);
            $table->string('status')->default('Upcoming'); // Upcoming, Ongoing, Completed
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Multiple images
            $table->text('highlights')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
