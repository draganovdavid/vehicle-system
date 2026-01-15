<x-app-layout>
    <x-slot name="header">
        Модели автомобили
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-gray-50 min-h-screen">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Car Models <span class="text-sm font-normal text-gray-600">({{ $models->count() }})</span></h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('models.store') }}" class="flex gap-2">
                        @csrf

                        <input name="name" placeholder="Model name" class="border border-gray-300 p-2 rounded">

                        <select name="manufacturer_id" class="border border-gray-300 p-2 rounded">
                            <option value="">-- choose manufacturer --</option>

                            @foreach($manufacturers as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>

                        <button class="bg-black text-black px-4 py-2 rounded font-medium hover:bg-gray-800">Add</button>
                    </form>
                @endif
            @endauth
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200" style="color: black !important;">
                <thead class="bg-gray-900 text-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Model</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Manufacturer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($models as $model)
                    <tr style="background-color: white !important;">
                        <td style="color: black !important; font-weight: bold !important; background-color: white !important;" class="px-6 py-4 whitespace-nowrap text-sm">{{ $model->name }}</td>
                        <td style="color: black !important; font-weight: 600 !important; background-color: white !important;" class="px-6 py-4 whitespace-nowrap text-sm">{{ $model->manufacturer->name }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('models.destroy', $model) }}" method="POST" onsubmit="return confirm('Delete this model?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-white bg-red-600 hover:bg-red-700">Delete</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-600">No models yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div> 
</x-app-layout>
