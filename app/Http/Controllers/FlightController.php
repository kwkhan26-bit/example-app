<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters(['departure_city', 'arrival_city', 'number'])
            ->allowedSorts(['departure_city', 'arrival_city', 'departure_time'])
            ->paginate($request->get('per_page', 15));

        return response()->json($flights);
    }

    public function passengers(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $passengers = $flight->passengers()->paginate($request->get('per_page', 15));
        return response()->json($passengers);
    }
}