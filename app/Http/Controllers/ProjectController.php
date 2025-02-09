<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            
            $projects = Project::all();
            return response()->json($projects);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Failed to retrieve projects','msg'=> $th->getMessage()], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $data = $this->handleRequest($request);
            $project = Project::create($data);
            return response()->json($project, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Failed to create project','msg'=> $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        try {
            $project = Project::find($id);
            if (!$project) {
                return response()->json(['error' => 'Project not found'], 404);
            }
            return response()->json($project);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Failed to retrieve project','msg'=> $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
        try {
            $project = Project::findOrFail($id);
            $data = $this->handleRequest($request);
            $project->update($data);
            return response()->json($project);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Failed to update project','msg'=> $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Failed to delete project','msg'=> $th->getMessage()], 500);
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
