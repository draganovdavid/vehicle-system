<x-app-layout>
    <x-slot name="header">
        Edit Vehicle
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-gray-50 min-h-screen">

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-lg font-semibold mb-6">Edit Vehicle</h2>

            <form method="POST" action="{{ route('vehicles.update', $vehicle) }}" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                {{-- Manufacturer --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manufacturer</label>
                    <select id="edit_manufacturer"
                            class="w-full border border-gray-300 p-3 rounded-lg">
                        @foreach($manufacturers as $man)
                            <option value="{{ $man->id }}"
                                {{ $vehicle->model->manufacturer->id == $man->id ? 'selected' : '' }}>
                                {{ $man->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Model --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                    <select name="car_model_id" id="edit_model"
                            class="w-full border border-gray-300 p-3 rounded-lg" required>
                        @foreach($models as $m)
                            <option value="{{ $m->id }}"
                                    data-manufacturer="{{ $m->manufacturer_id }}"
                                {{ $vehicle->car_model_id == $m->id ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Year --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <input name="year" type="number"
                           value="{{ old('year', $vehicle->year) }}"
                           class="w-full border border-gray-300 p-3 rounded-lg" required>
                </div>

                {{-- KM --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KM</label>
                    <input name="km" type="number"
                           value="{{ old('km', $vehicle->km) }}"
                           class="w-full border border-gray-300 p-3 rounded-lg" required>
                </div>

                {{-- Current Image --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>

                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" class="w-28 h-20 object-cover rounded shadow">
                    @else
                        <p class="text-gray-400 text-sm">No image</p>
                    @endif
                </div>

                {{-- New Image --}}
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Change Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 p-3 rounded-lg">
                </div>

                {{-- Buttons --}}
                <div class="sm:col-span-2 flex gap-3 justify-end mt-4">
                    <a href="{{ route('vehicles.index') }}"
                       class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 font-medium">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-6 py-2 rounded-lg !bg-indigo-600 !text-white hover:!bg-indigo-700 font-semibold shadow">
                        Update Vehicle
                    </button>


                </div>
            </form>
        </div>

    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const manufacturerSelect = document.getElementById('edit_manufacturer');
    const modelSelect = document.getElementById('edit_model');

    function updateModels(manufacturerId) {
        const options = modelSelect.querySelectorAll('option');

        options.forEach(option => {
            if (!option.dataset.manufacturer) return;

            if (option.dataset.manufacturer === manufacturerId) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }

    manufacturerSelect.addEventListener('change', function () {
        updateModels(this.value);
        modelSelect.value = '';
    });

    // Init on load
    updateModels(manufacturerSelect.value);
});
</script>
