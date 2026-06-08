<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    // GET /api/passengers
    public function index(Request $request)
{
    $passengers = QueryBuilder::for(Passenger::class)
        ->allowedFilters(['first_name', 'last_name', 'email'])
        ->allowedSorts(['first_name', 'last_name', 'email', 'date_of_birth'])
        ->paginate($request->get('per_page', 15));

    return response()->json($passengers);
}

    // GET /api/passengers/{id}
    public function show(Passenger $passenger)
    {
        return response()->json($passenger);
    }

    // POST /api/passengers
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'           => 'required|string',
            'last_name'            => 'required|string',
            'email'                => 'required|email|unique:passengers',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'date_of_birth'        => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);

        $passenger = Passenger::create($data);
        return response()->json($passenger, 201);
    }

    // PUT /api/passengers/{id}
    public function update(Request $request, Passenger $passenger)
    {
        $data = $request->validate([
            'first_name'           => 'string',
            'last_name'            => 'string',
            'email'                => 'email|unique:passengers,email,' . $passenger->id,
            'date_of_birth'        => 'date',
            'passport_expiry_date' => 'date',
        ]);

        $passenger->update($data);
        return response()->json($passenger);
    }

    // DELETE /api/passengers/{id}
    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response()->json(['message' => 'Passenger deleted']);
    }
}