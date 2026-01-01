<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🚗 Vehicle System
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('vehicles.store') }}" class="grid grid-cols-4 gap-2 mb-4">
                    @csrf
                    <input name="manufacturer" placeholder="Manufacturer" class="border px-2 py-1 rounded" />
                    <input name="model" placeholder="Model" class="border px-2 py-1 rounded" />
                    <input name="year" placeholder="Year" class="border px-2 py-1 rounded" />
                    <input name="kilometers" placeholder="Km" class="border px-2 py-1 rounded" />
                    <button class="col-span-4 bg-blue-500 text-white py-2 rounded">
                        Add Vehicle
                    </button>
                </form>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Manufacturer</th>
                            <th class="border p-2">Model</th>
                            <th class="border p-2">Year</th>
                            <th class="border p-2">Km</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                            <tr>
                                <td class="border p-2">{{ $vehicle->manufacturer }}</td>
                                <td class="border p-2">{{ $vehicle->model }}</td>
                                <td class="border p-2">{{ $vehicle->year }}</td>
                                <td class="border p-2">{{ $vehicle->kilometers }}</td>
                                <td class="border p-2 text-center">
                                    <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500">✖</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
