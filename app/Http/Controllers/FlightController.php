<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::query();

        // Filtering
        if ($request->has('departure_city')) {
            $query->where('departure_city', 'like', '%' . $request->departure_city . '%');
        }
        if ($request->has('arrival_city')) {
            $query->where('arrival_city', 'like', '%' . $request->arrival_city . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $flights = $query->paginate($request->get('per_page', 15));

        return response()->json($flights);
    }

    public function passengers(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $passengers = $flight->passengers()->paginate($request->get('per_page', 15));
        return response()->json($passengers);
    }
}