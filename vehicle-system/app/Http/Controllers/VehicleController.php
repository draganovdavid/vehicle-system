<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'kilometers' => 'required|integer',
        ]);

        Vehicle::create($request->all());

        return back();
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return back();
    }
}