<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->handleRequest($request);
        $imagePath = $request->hasFile('image') && $request->file('image')->isValid() ? 'storage/app/public/'.$request->file('image')->store('images', 'public') : null;
        $imageUrl = $imagePath ? asset($imagePath) : null;
        $data['image'] = $imageUrl;
        $brand = Brand::create($data);
        return response()->json($brand, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $brand)
    {
        $brand = Brand::find($brand);
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $this->handleRequest($request);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $imagePath = 'storage/app/public/'.$request->file('image')->store('images', 'public');
            $imageUrl = asset($imagePath);
            $data['image'] = $imageUrl;
        }
        $brand->update($data);
        return response()->json($brand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json(null, 204);
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
