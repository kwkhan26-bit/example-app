<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    // GET /api/passengers
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters(['first_name', 'last_name', 'email', AllowedFilter::scope('flight', 'whereHasFlight')])
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
            'first_name'           => 'required|string|max:255',
            'last_name'            => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:passengers',
            'password'             => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
            'date_of_birth'        => 'required|date|before:today',
            'passport_expiry_date' => 'required|date|after:today',
        ]);

        $passenger = Passenger::create($data);
        return response()->json($passenger, 201);
    }

    // PUT /api/passengers/{id}
    public function update(Request $request, Passenger $passenger)
    {
        $data = $request->validate([
            'first_name'           => 'string|max:255',
            'last_name'            => 'string|max:255',
            'email'                => 'email|max:255|unique:passengers,email,' . $passenger->id,
            'date_of_birth'        => 'date|before:today',
            'passport_expiry_date' => 'date|after:today',
        ]);

        $passenger->update($data);
        return response()->json($passenger);
    }

    // DELETE /api/passengers/{id}
    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response()->json(null, 204);
    }
}