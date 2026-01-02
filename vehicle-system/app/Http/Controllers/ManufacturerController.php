<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::latest()->get();
        return view('manufacturers.index', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'founded_at' => 'nullable|integer'
        ]);

        Manufacturer::create($request->all());
        return back();
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return back();
    }
}

