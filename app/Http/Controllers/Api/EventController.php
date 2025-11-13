<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of active events.
     */
    public function index(Request $request)
    {
        $query = Event::active();

        // Filter by status
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Sort by date
        $query->orderBy('start_date', 'desc');

        // Paginate
        $perPage = $request->get('per_page', 10);
        $events = $query->paginate($perPage);

        return response()->json($events);
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = Event::active()->findOrFail($id);
        return response()->json($event);
    }
}
