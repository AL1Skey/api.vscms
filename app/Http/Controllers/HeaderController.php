<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = Header::all();
        return response()->json($headers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->handleRequest($request);
        $header = Header::create($data);
        return response()->json($header, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $header)
    {
        $header = Header::find($header);
        return response()->json($header);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $header)
    {
        $data = $this->handleRequest($request);
        $header->update($data);
        return response()->json($header);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Header $header)
    {
        $header->delete();
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
