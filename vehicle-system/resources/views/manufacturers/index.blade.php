<x-app-layout>
    <x-slot name="header">
        Производители
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('manufacturers.store') }}" class="flex gap-2 mb-4">
            @csrf
            <input name="name" placeholder="Manufacturer name" class="border p-2 rounded w-full">
            <input name="founded_at" placeholder="Founded year" class="border p-2 rounded">
            <button class="bg-blue-600 text-white px-4 rounded">Add</button>
        </form>

        <table class="w-full">
            @foreach($manufacturers as $m)
                <tr class="border-b">
                    <td class="p-2">{{ $m->name }}</td>
                    <td class="p-2">{{ $m->founded_at }}</td>
                    <td class="p-2">
                        <form method="POST" action="{{ route('manufacturers.destroy',$m) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
