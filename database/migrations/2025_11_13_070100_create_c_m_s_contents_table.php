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
        Schema::create('c_m_s_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // hero, about, cta, etc.
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Multiple images for gallery
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->json('metadata')->nullable(); // For additional custom fields
            $table->boolean('is_visible')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_m_s_contents');
    }
};
