<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModel::with('manufacturer')->latest()->get();
        $manufacturers = Manufacturer::all();

        return view('car_models.index', compact('models', 'manufacturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'manufacturer_id' => 'required|exists:manufacturers,id'
        ]);

        CarModel::create($request->all());

        return back();
    }

    public function destroy(CarModel $carModel)
    {
        $carModel->delete();

        return back();
    }
}
