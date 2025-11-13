<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of active testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::active();

        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Sort by latest
        $query->orderBy('created_at', 'desc');

        // Paginate
        $perPage = $request->get('per_page', 12);
        $testimonials = $query->paginate($perPage);

        return response()->json($testimonials);
    }

    /**
     * Display the specified testimonial.
     */
    public function show($id)
    {
        $testimonial = Testimonial::active()->findOrFail($id);
        return response()->json($testimonial);
    }
}
