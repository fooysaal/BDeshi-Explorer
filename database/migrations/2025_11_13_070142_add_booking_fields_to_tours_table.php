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
        Schema::table('tours', function (Blueprint $table) {
            $table->foreignId('hosted_by')->nullable()->after('slug')->constrained('users')->onDelete('set null');
            $table->date('start_date')->nullable()->after('duration');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('total_capacity')->default(0)->after('max_participants');
            $table->integer('available_capacity')->default(0)->after('total_capacity');
            $table->text('safety_terms')->nullable()->after('excluded');
            $table->json('gallery')->nullable()->after('images'); // JSON array of gallery images
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['hosted_by']);
            $table->dropColumn([
                'hosted_by',
                'start_date',
                'end_date',
                'total_capacity',
                'available_capacity',
                'safety_terms',
                'gallery',
                'status'
            ]);
        });
    }
};
