<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $brands = Brand::all();
            return response()->json($brands);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to retrieve brands'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->handleRequest($request);
            $imagePath = $request->hasFile('image') && $request->file('image')->isValid() ? 'storage/app/public/'.$request->file('image')->store('images', 'public') : null;
            $imageUrl = $imagePath ? asset($imagePath) : null;
            $data['image'] = $imageUrl;
            $brand = Brand::create($data);
            return response()->json($brand, 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to create brand'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($brand)
    {
        try {
            $brand = Brand::find($brand);
            if (!$brand) {
                return response()->json(['error' => 'Brand not found'], 404);
            }
            return response()->json($brand);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to retrieve brand'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $data = $this->handleRequest($request);
            if($request->hasFile('image') && $request->file('image')->isValid()){
                $imagePath = 'storage/app/public/'.$request->file('image')->store('images', 'public');
                $imageUrl = asset($imagePath);
                $data['image'] = $imageUrl;
            }
            $brand->update($data);
            return response()->json($brand);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to update brand'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $brand= Brand::findOrFail($id);
            $brand->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete brand'], 500);
        }
    }

    private function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags($input));
    }

    private function handleRequest(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = $this->sanitizeInput($value);
            }
        }
        return $data;
    }
}
