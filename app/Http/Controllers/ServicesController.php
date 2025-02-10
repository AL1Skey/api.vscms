<?php
namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $query = Services::query();

        // Sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->get('sort_by'), $request->get('sort_order', 'asc'));
        }

        // Filtering and Search
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }
        if ($request->has('price')) {
            $query->where('price', $request->get('price'));
        }
        if ($request->has('custom')) {
            $query->where('custom', 'like', '%' . $request->get('custom') . '%');
        }
        if ($request->has('pembeli')) {
            $query->where('pembeli', 'like', '%' . $request->get('pembeli') . '%');
        }
        // Include the 'category' relationship in the query results
        // $query->with('service_list_id');
        // Pagination
        $services = $query->paginate(10);

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'service_list' => 'nullable|string',
        ]);
       
        $data = $this->handleRequest($request);
        $services = Services::create($data);
        return response()->json($services, 201);
    }

    public function show($id)
    {
        $query = Services::query();
        // $query->with('category');
        $services = $query->findOrFail($id);
        return response()->json($services);
    }

    public function update(Request $request, $id)
    {
        $services = Services::findOrFail($id);

        $data = $this->handleRequest($request);
        $services->update($data);
        return response()->json($services);
    }

    public function destroy($id)
    {
        $services = Services::findOrFail($id);
        $services->delete();

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
