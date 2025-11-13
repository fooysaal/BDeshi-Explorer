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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique(); // Auto-generated booking reference
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');

            // Booking Details
            $table->integer('number_of_people')->default(1);
            $table->decimal('total_amount', 10, 2);
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->text('special_requests')->nullable();

            // Payment Information
            $table->enum('payment_method', ['bank_transfer', 'mfs_service', 'pay_later'])->default('pay_later');
            $table->string('mfs_provider')->nullable(); // bKash, Nagad, Rocket, etc.
            $table->string('transaction_id')->nullable();
            $table->string('payment_receipt')->nullable(); // File path for uploaded receipt
            $table->timestamp('payment_date')->nullable();

            // Booking Status Management
            $table->enum('status', ['pending', 'in_process', 'approved', 'cancelled', 'completed'])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            // Notes and Metadata
            $table->text('admin_notes')->nullable();
            $table->json('metadata')->nullable(); // For additional custom data

            $table->timestamps();
            $table->softDeletes(); // Soft delete for record keeping

            // Indexes for performance
            $table->index('booking_number');
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index(['tour_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
