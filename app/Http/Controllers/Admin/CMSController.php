<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CMSContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CMSController extends Controller
{
    /**
     * Display a listing of the CMS contents.
     */
    public function index(Request $request)
    {
        $query = CMSContent::query()->ordered();

        if ($request->has('section_key')) {
            $query->bySection($request->section_key);
        }

        if ($request->has('visible')) {
            $query->visible();
        }

        $contents = $query->paginate($request->get('per_page', 15));

        return response()->json($contents);
    }

    /**
     * Store a newly created CMS content.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_key' => 'required|string|unique:c_m_s_contents,section_key',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'metadata' => 'nullable|array',
            'is_visible' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $content = CMSContent::create($validator->validated());

        return response()->json([
            'message' => 'CMS content created successfully',
            'data' => $content
        ], 201);
    }

    /**
     * Display the specified CMS content.
     */
    public function show($id)
    {
        $content = CMSContent::findOrFail($id);
        return response()->json($content);
    }

    /**
     * Update the specified CMS content.
     */
    public function update(Request $request, $id)
    {
        $content = CMSContent::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section_key' => 'sometimes|string|unique:c_m_s_contents,section_key,' . $id,
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'metadata' => 'nullable|array',
            'is_visible' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $content->update($validator->validated());

        return response()->json([
            'message' => 'CMS content updated successfully',
            'data' => $content
        ]);
    }

    /**
     * Remove the specified CMS content.
     */
    public function destroy($id)
    {
        $content = CMSContent::findOrFail($id);
        $content->delete();

        return response()->json([
            'message' => 'CMS content deleted successfully'
        ]);
    }

    /**
     * Toggle visibility of CMS content
     */
    public function toggleVisibility($id)
    {
        $content = CMSContent::findOrFail($id);
        $content->is_visible = !$content->is_visible;
        $content->save();

        return response()->json([
            'message' => 'Visibility toggled successfully',
            'data' => $content
        ]);
    }
}
