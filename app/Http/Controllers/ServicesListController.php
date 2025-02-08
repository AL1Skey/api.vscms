<?php

namespace App\Http\Controllers;

use App\Models\ServicesList;
use Illuminate\Http\Request;

class ServicesListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services_lists = ServicesList::all();
        return response()->json($services_lists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->handleRequest($request);
        $services_list = ServicesList::create($data);
        return response()->json($services_list, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $services_list)
    {
        $services_list = ServicesList::find($services_list);
        return response()->json($services_list);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicesList $services_list)
    {
        $data = $this->handleRequest($request);
        $services_list->update($data);
        return response()->json($services_list);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicesList $services_list)
    {
        $services_list->delete();
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
