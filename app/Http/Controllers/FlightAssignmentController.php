<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlightAssignmentController extends Controller
{
    // POST /api/flights/{id}/assign
    public function assign(Request $request, Flight $flight)
    {
        $request->validate([
            'passenger_id' => [
                'required',
                Rule::exists('passengers', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $flight->passengers()->syncWithoutDetaching([$request->passenger_id]);
        return response()->json(['message' => 'Passenger assigned to flight']);
    }

    // DELETE /api/flights/{id}/unassign
    public function unassign(Request $request, Flight $flight)
    {
        $request->validate([
            'passenger_id' => [
                'required',
                Rule::exists('passengers', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $flight->passengers()->detach($request->passenger_id);
        return response()->json(null, 204);
    }
}