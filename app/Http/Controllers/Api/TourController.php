<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of active tours.
     */
    public function index(Request $request)
    {
        $query = Tour::active();

        // Filter by category
        if ($request->has('category') && $request->category !== 'All') {
            $query->byCategory($request->category);
        }

        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $perPage = $request->get('per_page', 12);
        $tours = $query->paginate($perPage);

        return response()->json($tours);
    }

    /**
     * Display the specified tour.
     */
    public function show($id)
    {
        $tour = Tour::active()->findOrFail($id);
        return response()->json($tour);
    }
}
