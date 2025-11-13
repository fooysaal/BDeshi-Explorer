<?php

use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\AdminTourController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Authentication Routes - No auth required
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public APIs - No authentication required
    Route::prefix('public')->group(function () {
        // Tours API
        Route::get('/tours', [TourController::class, 'index']);
        Route::get('/tours/{id}', [TourController::class, 'show']);

        // Events API
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{id}', [EventController::class, 'show']);

        // Testimonials API
        Route::get('/testimonials', [TestimonialController::class, 'index']);
        Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);
    });

    // Protected Routes - Require authentication
    Route::middleware('auth:sanctum')->group(function () {

        // Auth User Routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);

        // Explorer Routes - All authenticated users can book
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index']);
            Route::post('/', [BookingController::class, 'store']);
            Route::get('/{id}', [BookingController::class, 'show']);
            Route::post('/{id}/cancel', [BookingController::class, 'cancel']);
            Route::put('/{id}/payment', [BookingController::class, 'updatePayment']);
        });

        // Admin & Moderator Routes
        Route::middleware('role:admin,moderator')->group(function () {

            // CMS Management
            Route::prefix('admin/cms')->group(function () {
                Route::get('/', [CMSController::class, 'index']);
                Route::post('/', [CMSController::class, 'store']);
                Route::get('/{id}', [CMSController::class, 'show']);
                Route::put('/{id}', [CMSController::class, 'update']);
                Route::delete('/{id}', [CMSController::class, 'destroy']);
                Route::post('/{id}/toggle-visibility', [CMSController::class, 'toggleVisibility']);
            });

            // Tour Management
            Route::prefix('admin/tours')->group(function () {
                Route::get('/', [AdminTourController::class, 'index']);
                Route::post('/', [AdminTourController::class, 'store']);
                Route::get('/{id}', [AdminTourController::class, 'show']);
                Route::put('/{id}', [AdminTourController::class, 'update']);
                Route::delete('/{id}', [AdminTourController::class, 'destroy']);
                Route::post('/{id}/status', [AdminTourController::class, 'updateStatus']);
            });

            // Booking Management
            Route::prefix('admin/bookings')->group(function () {
                Route::get('/', [AdminBookingController::class, 'index']);
                Route::get('/statistics', [AdminBookingController::class, 'statistics']);
                Route::get('/{id}', [AdminBookingController::class, 'show']);
                Route::post('/{id}/in-process', [AdminBookingController::class, 'markInProcess']);
                Route::post('/{id}/approve', [AdminBookingController::class, 'approve']);
                Route::post('/{id}/cancel', [AdminBookingController::class, 'cancel']);
                Route::post('/{id}/complete', [AdminBookingController::class, 'markCompleted']);
                Route::put('/{id}/notes', [AdminBookingController::class, 'updateNotes']);
            });
        });
    });
});
