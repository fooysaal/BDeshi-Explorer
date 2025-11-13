<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a moderator
     */
    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    /**
     * Check if user is an explorer (regular user)
     */
    public function isExplorer(): bool
    {
        return $this->role === 'explorer';
    }

    /**
     * Check if user has admin or moderator privileges
     */
    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }

    /**
     * Tours hosted by this user (if admin/moderator)
     */
    public function hostedTours()
    {
        return $this->hasMany(Tour::class, 'hosted_by');
    }

    /**
     * Bookings made by this user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Bookings approved by this user (if admin/moderator)
     */
    public function approvedBookings()
    {
        return $this->hasMany(Booking::class, 'approved_by');
    }
}
