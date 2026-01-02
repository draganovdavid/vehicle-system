<x-app-layout>
    <x-slot name="header">
        Модели автомобили
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('models.store') }}" class="flex gap-2 mb-4">
            @csrf

            <input name="name" placeholder="Model name" class="border p-2 rounded w-full">

            <select name="manufacturer_id" class="border p-2 rounded">
                <option value="">-- choose manufacturer --</option>

                @foreach($manufacturers as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                @endforeach
            </select>

            <button class="bg-green-600 text-white px-4 rounded">
                Add
            </button>
        </form>

        <table class="w-full">
            @foreach($models as $model)
                <tr class="border-b">
                    <td class="p-2">{{ $model->name }}</td>
                    <td class="p-2 text-gray-600">{{ $model->manufacturer->name }}</td>

                    <td class="p-2">
                        <form action="{{ route('models.destroy', $model) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
</x-app-layout>
