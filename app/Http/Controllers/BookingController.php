<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of user's bookings.
     */
    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->with('tour')
            ->latest()
            ->paginate(10);

        return response()->json($bookings);
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id' => 'required|exists:tours,id',
            'number_of_participants' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'payment_method' => 'required|in:bank_transfer,mfs_service,pay_later',
            'mfs_provider' => 'required_if:payment_method,mfs_service|in:bkash,nagad,rocket',
            'transaction_id' => 'required_unless:payment_method,pay_later|string|max:255',
            'payment_receipt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tour = Tour::findOrFail($request->tour_id);

        // Check if tour is available for booking
        if (!$tour->is_active || $tour->status === 'cancelled') {
            return response()->json([
                'message' => 'This tour is not available for booking'
            ], 422);
        }

        // Check capacity
        if (!$tour->hasAvailableSlots($request->number_of_participants)) {
            return response()->json([
                'message' => 'Not enough available slots. Available: ' . $tour->available_capacity
            ], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = $request->user()->id;
        $data['total_price'] = $tour->price * $request->number_of_participants;
        $data['status'] = 'pending';

        $booking = Booking::create($data);

        return response()->json([
            'message' => 'Booking created successfully. Please wait for admin approval.',
            'data' => $booking->load('tour')
        ], 201);
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        $booking = Booking::with(['tour', 'approver'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($booking);
    }

    /**
     * Cancel user's own booking
     */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status === 'completed') {
            return response()->json([
                'message' => 'Cannot cancel completed bookings'
            ], 422);
        }

        if ($booking->status === 'cancelled') {
            return response()->json([
                'message' => 'Booking is already cancelled'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking->cancel($request->cancellation_reason);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'data' => $booking->load('tour')
        ]);
    }

    /**
     * Update payment information
     */
    public function updatePayment(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Can only update payment for pending bookings'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:bank_transfer,mfs_service,pay_later',
            'mfs_provider' => 'required_if:payment_method,mfs_service|in:bkash,nagad,rocket',
            'transaction_id' => 'required_unless:payment_method,pay_later|string|max:255',
            'payment_receipt' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking->update($validator->validated());

        return response()->json([
            'message' => 'Payment information updated successfully',
            'data' => $booking
        ]);
    }
}
