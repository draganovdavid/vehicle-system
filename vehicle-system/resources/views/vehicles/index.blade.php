<x-app-layout>
    <x-slot name="header">
        Автомобили
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto bg-gray-50 min-h-screen">

        @auth
        {{-- Grid: Filters + (Admin only) Create Vehicle --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- Filters – видими за всички логнати потребители --}}
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Search & Filter</h3>

                <form method="GET" action="{{ route('vehicles.index') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2 uppercase tracking-wider">Manufacturer</label>
                        <select name="manufacturer_id" id="filter_manufacturer"
                                class="w-full border border-gray-300 p-3 rounded-lg bg-white text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Manufacturers</option>
                            @foreach($manufacturers as $man)
                                <option value="{{ $man->id }}" {{ request('manufacturer_id') == $man->id ? 'selected' : '' }}>
                                    {{ $man->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2 uppercase tracking-wider">Model</label>
                        <select name="car_model_id" id="filter_model"
                                class="w-full border border-gray-300 p-3 rounded-lg bg-white text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Models</option>
                            @foreach($models as $m)
                                <option value="{{ $m->id }}" data-manufacturer="{{ $m->manufacturer_id }}">
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2 uppercase tracking-wider">Year</label>
                        <input name="year" type="number"
                               class="w-full border border-gray-300 p-3 rounded-lg text-sm" placeholder="e.g. 2023" value="{{ request('year') }}">
                    </div>

                    <div class="flex gap-2 items-end">
                        <button type="submit"
                            class="flex-1 !bg-gray-900 !text-white px-4 py-3 rounded-lg font-semibold hover:!bg-gray-800 transition shadow">
                            Search
                        </button>

                        @if(request()->anyFilled(['manufacturer_id','car_model_id','year']))
                            <a href="{{ route('vehicles.index') }}"
                                class="flex-1 !bg-gray-900 !text-white px-4 py-3 rounded-lg font-semibold hover:!bg-gray-800 transition shadow text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Create Vehicle – само за администратори --}}
            @if(auth()->user()->isAdmin())
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Add New Vehicle</h3>

                <form method="POST" action="{{ route('vehicles.store') }}"
                      class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                      enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Manufacturer</label>
                        <select name="manufacturer_id" id="create_manufacturer"
                                class="w-full border border-gray-300 p-3 rounded-lg" required>
                            <option value="">Choose manufacturer</option>
                            @foreach($manufacturers as $man)
                                <option value="{{ $man->id }}">{{ $man->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <select name="car_model_id" id="create_model"
                                class="w-full border border-gray-300 p-3 rounded-lg" required>
                            <option value="">Choose model</option>
                            @foreach($models as $m)
                                <option value="{{ $m->id }}" data-manufacturer="{{ $m->manufacturer_id }}">
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                        <input name="year" type="number" placeholder="Year"
                               class="w-full border border-gray-300 p-3 rounded-lg" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">KM</label>
                        <input name="km" type="number" placeholder="Kilometers"
                               class="w-full border border-gray-300 p-3 rounded-lg" required>
                    </div>

                    <div class="sm:col-span-2 flex gap-3 items-end">
                        <input type="file" name="image"
                               class="flex-1 border border-gray-300 p-3 rounded-lg">
                        <button type="submit"
                                class="bg-black text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-800">
                            Add Vehicle
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
        @endauth

        {{-- Vehicles List Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Vehicles List</h2>
        </div>

        {{-- Vehicles Table --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-900 text-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Manufacturer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Model</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Year</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">KM</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Image</th>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Actions</th>
                            @endif
                        @endauth

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vehicles as $v)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $v->model->manufacturer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $v->model->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $v->year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($v->km) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($v->image_url)
                                    <img src="{{ $v->image_url }}" alt="" class="w-24 h-16 object-cover rounded shadow-sm">
                                @else
                                    <div class="w-28 h-18 bg-gray-100 rounded flex items-center justify-center text-sm text-gray-400">No image</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('vehicles.edit', $v) }}"
                                               class="inline-flex items-center justify-center h-9 px-4 
                                                      text-sm font-semibold rounded-lg 
                                                      bg-blue-600 text-black hover:bg-blue-700 transition shadow">
                                                ✏️ Edit
                                            </a>

                                            <form method="POST" action="{{ route('vehicles.destroy', $v) }}" onsubmit="return confirm('Delete this vehicle?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="inline-flex items-center justify-center h-9 px-4 
                                                           text-sm font-semibold rounded-lg 
                                                           bg-red-600 text-white hover:bg-red-700 transition shadow">
                                                    🗑 Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-600">No vehicles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterManufacturer = document.getElementById('filter_manufacturer');
    const filterModel = document.getElementById('filter_model');
    const createManufacturer = document.getElementById('create_manufacturer');
    const createModel = document.getElementById('create_model');

    function updateModels(manufacturerId, modelSelectId) {
        const modelSelect = document.getElementById(modelSelectId);
        if (!modelSelect) return;

        const allOptions = Array.from(modelSelect.querySelectorAll('option[data-manufacturer]'));
        const emptyOption = modelSelect.querySelector('option:not([data-manufacturer])');

        allOptions.forEach(option => {
            if (manufacturerId === '' || option.dataset.manufacturer === manufacturerId) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });

        if (emptyOption) emptyOption.style.display = '';
    }

    if (filterManufacturer) {
        filterManufacturer.addEventListener('change', function() {
            updateModels(this.value, 'filter_model');
            if (filterModel) filterModel.value = '';
        });
        updateModels(filterManufacturer.value, 'filter_model');
    }

    if (createManufacturer) {
        createManufacturer.addEventListener('change', function() {
            updateModels(this.value, 'create_model');
            if (createModel) createModel.value = '';
        });
    }
});
</script>
