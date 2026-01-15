<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FeatureController extends Controller
{
    public function index()
    { 
        $features = Feature::latest()->get();
        return view('admin.features.lists', compact('features'));
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'   => 'required|string|min:3|max:100|unique:features,name',
                'status' => 'required|boolean',
            ]);

            $feature = Feature::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Feature created successfully',
                'data'    => $feature,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create feature',
            ], 500);
        }
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        try {
            $feature = Feature::findOrFail($id);

            $validated = $request->validate([
                'name'   => 'required|string|min:3|max:100|unique:features,name,' . $feature->id,
                'status' => 'required|boolean',
            ]);

            $feature->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Feature updated successfully',
                'data'    => $feature,
            ]);

        
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update feature',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $feature = Feature::findOrFail($id);
            $feature->delete(); // soft delete

            return response()->json([
                'success' => true,
                'message' => 'Feature deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete feature',
            ], 500);
        }
    }
}
