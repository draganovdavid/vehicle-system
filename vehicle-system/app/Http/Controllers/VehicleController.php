<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\CarModel;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('model.manufacturer')->latest();

        // Filters
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('car_model_id')) {
            $query->where('car_model_id', $request->car_model_id);
        }

        if ($request->filled('manufacturer_id')) {
            $query->whereHas('model', function ($q) use ($request) {
                $q->where('manufacturer_id', $request->manufacturer_id);
            });
        }

        $vehicles = $query->get();

        $models = CarModel::with('manufacturer')->get();
        $manufacturers = Manufacturer::all();

        return view('vehicles.index', compact('vehicles', 'models', 'manufacturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_model_id' => 'required|exists:car_models,id',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'km' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['car_model_id', 'year', 'km']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vehicles', 'public');
            $data['image'] = $path;
        }

        Vehicle::create($data);

        return back();
    }

    public function edit(Vehicle $vehicle)
{
    $models = CarModel::with('manufacturer')->get();
    $manufacturers = Manufacturer::all();

    return view('vehicles.edit', compact('vehicle', 'models', 'manufacturers'));
}

public function update(Request $request, Vehicle $vehicle)
{
    $request->validate([
        'car_model_id' => 'required|exists:car_models,id',
        'year' => 'required|integer|min:1900|max:' . date('Y'),
        'km' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048'
    ]);

    $data = $request->only(['car_model_id', 'year', 'km']);

    if ($request->hasFile('image')) {
        // Delete old image
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }

        $path = $request->file('image')->store('vehicles', 'public');
        $data['image'] = $path;
    }

    $vehicle->update($data);

    return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
}


    public function destroy(Vehicle $vehicle)
    {
        // remove image if there is one
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }

        $vehicle->delete();
        return back();
    }
}
