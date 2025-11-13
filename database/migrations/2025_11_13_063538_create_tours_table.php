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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->string('duration');
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 2, 1)->default(0);
            $table->string('availability')->default('Available');
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Multiple images
            $table->string('category')->default('General');
            $table->integer('max_participants')->nullable();
            $table->text('highlights')->nullable();
            $table->text('itinerary')->nullable();
            $table->text('included')->nullable();
            $table->text('excluded')->nullable();
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
        Schema::dropIfExists('tours');
    }
};
