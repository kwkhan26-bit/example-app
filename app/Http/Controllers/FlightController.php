<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FlightController extends Controller
{
    // GET /api/flights
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters(['departure_city', 'arrival_city', 'number'])
            ->allowedSorts(['departure_city', 'arrival_city', 'departure_time'])
            ->paginate($request->get('per_page', 15));

        return response()->json($flights);
    }

    // GET /api/flights/{id}
    public function show(Flight $flight)
    {
        return response()->json($flight);
    }

    // POST /api/flights
    public function store(Request $request)
    {
        $data = $request->validate([
            'number'         => 'required|string|max:255|unique:flights',
            'departure_city' => 'required|string|max:255',
            'arrival_city'   => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time'   => 'required|date|after:departure_time', // Updated validation
        ]);

        $flight = Flight::create($data);
        return response()->json($flight, 201);
    }

    // PUT /api/flights/{id}
    public function update(Request $request, Flight $flight)
    {
        $data = $request->validate([
            'number'         => 'string|max:255|unique:flights,number,' . $flight->id,
            'departure_city' => 'string|max:255',
            'arrival_city'   => 'string|max:255',
            'departure_time' => 'date',
            'arrival_time'   => 'date|after:departure_time', // Updated validation
        ]);

        $flight->update($data);
        return response()->json($flight);
    }

    // DELETE /api/flights/{id}
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json(null, 204);
    }
}