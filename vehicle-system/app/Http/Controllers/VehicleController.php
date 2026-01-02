<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\CarModel;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('model.manufacturer')->latest()->get();
        $models = CarModel::with('manufacturer')->get();

        return view('vehicles.index', compact('vehicles', 'models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'km' => 'required|integer|min:0'
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
