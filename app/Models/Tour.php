<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'duration',
        'price',
        'rating',
        'availability',
        'image',
        'images',
        'category',
        'max_participants',
        'highlights',
        'itinerary',
        'included',
        'excluded',
        'is_featured',
        'is_active',
        'hosted_by',
        'start_date',
        'end_date',
        'total_capacity',
        'available_capacity',
        'safety_terms',
        'gallery',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the host (admin/moderator) of the tour
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'hosted_by');
    }

    /**
     * Get all bookings for this tour
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get approved bookings for this tour
     */
    public function approvedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'approved');
    }

    /**
     * Scope to get only active tours
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured tours
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get upcoming tours
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Scope to get ongoing tours
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Check if tour has available slots
     */
    public function hasAvailableSlots($requestedSlots = 1): bool
    {
        return $this->available_capacity >= $requestedSlots;
    }

    /**
     * Calculate total booked participants
     */
    public function getTotalBookedAttribute(): int
    {
        return $this->total_capacity - $this->available_capacity;
    }
}
