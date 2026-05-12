<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters(['first_name', 'last_name', 'email', AllowedFilter::exact('flight_id')])
            ->allowedSorts(['first_name', 'last_name', 'email', 'dob'])
            ->paginate($request->get('per_page', 15));

        return response()->json($passengers);
    }
}