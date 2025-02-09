<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footers = Footer::all();
        return response()->json($footers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->handleRequest($request);
        $footer = Footer::create($data);
        return response()->json($footer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($footer)
    {
        $footer = Footer::findOrFail($footer);
        return response()->json($footer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {   
        $footer = Footer::findOrFail($id);
        $data = $this->handleRequest($request);
        $footer->update($data);
        return response()->json($footer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->delete();
        return response()->json(null, 204);
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

    private function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags($input));
    }
}
