<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_number',
        'user_id',
        'tour_id',
        'number_of_people',
        'total_amount',
        'contact_name',
        'contact_email',
        'contact_phone',
        'special_requests',
        'payment_method',
        'mfs_provider',
        'transaction_id',
        'payment_receipt',
        'payment_date',
        'status',
        'cancellation_reason',
        'approved_by',
        'approved_at',
        'admin_notes',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Boot method to generate booking number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_number) {
                $booking->booking_number = 'BK' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the user who made the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tour being booked
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get the admin/moderator who approved the booking
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for in-process bookings
     */
    public function scopeInProcess($query)
    {
        return $query->where('status', 'in_process');
    }

    /**
     * Scope for approved bookings
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for cancelled bookings
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if payment info is provided
     */
    public function hasPaymentInfo(): bool
    {
        return !empty($this->transaction_id) || !empty($this->payment_receipt);
    }

    /**
     * Approve the booking
     */
    public function approve($approvedBy)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);

        // Decrease available capacity
        $this->tour->decrement('available_capacity', $this->number_of_people);
    }

    /**
     * Cancel the booking
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
        ]);

        // Restore capacity if previously approved
        if ($this->status === 'approved') {
            $this->tour->increment('available_capacity', $this->number_of_people);
        }
    }
}
