<x-app-layout>
    <x-slot name="header">
        Автомобили
    </x-slot>

    <div class="p-6 max-w-5xl mx-auto">

        {{-- Create form --}}
        <form method="POST" action="{{ route('vehicles.store') }}" class="grid grid-cols-4 gap-3 mb-6">
            @csrf

            {{-- Model --}}
            <select name="car_model_id" class="border p-2 rounded" required>
                <option value="">-- choose model --</option>

                @foreach($models as $m)
                    <option value="{{ $m->id }}">
                        {{ $m->manufacturer->name }} — {{ $m->name }}
                    </option>
                @endforeach
            </select>

            {{-- Year --}}
            <input name="year" type="number" placeholder="Year"
                   class="border p-2 rounded" required>

            {{-- KM --}}
            <input name="km" type="number" placeholder="Kilometers"
                   class="border p-2 rounded" required>

            <button class="bg-blue-600 text-white rounded px-4">
                Add Vehicle
            </button>
        </form>

        {{-- Table --}}
        <table class="w-full text-left">
            <tr class="font-bold border-b">
                <td>Manufacturer</td>
                <td>Model</td>
                <td>Year</td>
                <td>KM</td>
                <td></td>
            </tr>

            @foreach($vehicles as $v)
                <tr class="border-b">
                    <td>{{ $v->model->manufacturer->name }}</td>
                    <td>{{ $v->model->name }}</td>
                    <td>{{ $v->year }}</td>
                    <td>{{ $v->km }}</td>

                    <td>
                        <form method="POST" action="{{ route('vehicles.destroy', $v) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
