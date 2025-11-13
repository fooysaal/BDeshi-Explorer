<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminTourController extends Controller
{
    /**
     * Display a listing of all tours (admin view).
     */
    public function index(Request $request)
    {
        $query = Tour::with('host');

        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tours = $query->paginate($request->get('per_page', 15));

        return response()->json($tours);
    }

    /**
     * Store a newly created tour.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'category' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_capacity' => 'required|integer|min:1',
            'safety_terms' => 'nullable|string',
            'gallery' => 'nullable|array',
            'max_participants' => 'nullable|integer|min:1',
            'highlights' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'in:draft,upcoming,ongoing,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['hosted_by'] = $request->user()->id;
        $data['available_capacity'] = $data['total_capacity'];

        $tour = Tour::create($data);

        return response()->json([
            'message' => 'Tour created successfully',
            'data' => $tour->load('host')
        ], 201);
    }

    /**
     * Display the specified tour.
     */
    public function show($id)
    {
        $tour = Tour::with(['host', 'bookings.user'])->findOrFail($id);
        return response()->json($tour);
    }

    /**
     * Update the specified tour.
     */
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'duration' => 'sometimes|string|max:100',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|string',
            'images' => 'nullable|array',
            'category' => 'sometimes|string|max:100',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'total_capacity' => 'sometimes|integer|min:1',
            'available_capacity' => 'sometimes|integer|min:0',
            'safety_terms' => 'nullable|string',
            'gallery' => 'nullable|array',
            'max_participants' => 'nullable|integer|min:1',
            'highlights' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'status' => 'in:draft,upcoming,ongoing,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Update slug if name is changed
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tour->update($data);

        return response()->json([
            'message' => 'Tour updated successfully',
            'data' => $tour->load('host')
        ]);
    }

    /**
     * Remove the specified tour.
     */
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        // Check if there are approved bookings
        if ($tour->approvedBookings()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete tour with approved bookings'
            ], 422);
        }

        $tour->delete();

        return response()->json([
            'message' => 'Tour deleted successfully'
        ]);
    }

    /**
     * Update tour status
     */
    public function updateStatus(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:draft,upcoming,ongoing,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tour->status = $request->status;
        $tour->save();

        return response()->json([
            'message' => 'Tour status updated successfully',
            'data' => $tour
        ]);
    }
}
