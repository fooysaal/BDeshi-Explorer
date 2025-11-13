<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of all bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'approver']);

        if ($request->has('status')) {
            $status = $request->status;
            $query->where('status', $status);
        }

        if ($request->has('tour_id')) {
            $query->where('tour_id', $request->tour_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($bookings);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'tour.host', 'approver'])->findOrFail($id);
        return response()->json($booking);
    }

    /**
     * Update booking status to in_process
     */
    public function markInProcess(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending bookings can be marked as in process'
            ], 422);
        }

        $booking->status = 'in_process';
        $booking->save();

        return response()->json([
            'message' => 'Booking marked as in process',
            'data' => $booking->load(['user', 'tour'])
        ]);
    }

    /**
     * Approve a booking
     */
    public function approve(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (!in_array($booking->status, ['pending', 'in_process'])) {
            return response()->json([
                'message' => 'Only pending or in-process bookings can be approved'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if tour has available capacity
        if (!$booking->tour->hasAvailableSlots($booking->number_of_participants)) {
            return response()->json([
                'message' => 'Tour does not have enough available slots'
            ], 422);
        }

        if ($request->has('admin_notes')) {
            $booking->admin_notes = $request->admin_notes;
        }

        $booking->approve($request->user()->id);

        return response()->json([
            'message' => 'Booking approved successfully',
            'data' => $booking->load(['user', 'tour', 'approver'])
        ]);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'completed') {
            return response()->json([
                'message' => 'Cannot cancel completed bookings'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('admin_notes')) {
            $booking->admin_notes = $request->admin_notes;
        }

        $booking->cancel($request->cancellation_reason);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'data' => $booking->load(['user', 'tour'])
        ]);
    }

    /**
     * Mark booking as completed
     */
    public function markCompleted($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'approved') {
            return response()->json([
                'message' => 'Only approved bookings can be marked as completed'
            ], 422);
        }

        $booking->status = 'completed';
        $booking->save();

        return response()->json([
            'message' => 'Booking marked as completed',
            'data' => $booking->load(['user', 'tour'])
        ]);
    }

    /**
     * Update admin notes
     */
    public function updateNotes(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'admin_notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking->admin_notes = $request->admin_notes;
        $booking->save();

        return response()->json([
            'message' => 'Admin notes updated successfully',
            'data' => $booking
        ]);
    }

    /**
     * Get booking statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::pending()->count(),
            'in_process' => Booking::inProcess()->count(),
            'approved' => Booking::approved()->count(),
            'cancelled' => Booking::cancelled()->count(),
            'completed' => Booking::completed()->count(),
            'total_revenue' => Booking::approved()->sum('total_price'),
        ];

        return response()->json($stats);
    }
}
