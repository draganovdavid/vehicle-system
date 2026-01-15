<x-app-layout>
    <x-slot name="header">Потребители (Admin)</x-slot>

    <div class="p-6 max-w-5xl mx-auto bg-gray-50 min-h-screen">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">User Management</h2>
            <p class="text-sm text-gray-600">Assign or revoke admin roles and manage user accounts</p>
        </div>

        {{-- Success & Error Messages --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-800 border border-green-200 rounded-lg">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 text-red-800 border border-red-200 rounded-lg">{{ session('error') }}</div>
        @endif

        {{-- Search Form --}}
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name or email"
                       class="flex-1 border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-500"
                >
                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-black font-semibold rounded-lg hover:bg-indigo-700 transition shadow">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}"
                       class="px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition shadow">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Users Table --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200" style="color: black !important;">
                <thead class="bg-gray-900 text-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Admin</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $u)
                        <tr style="background-color: white !important;">
                            <td style="color: black !important; font-weight: bold !important; background-color: white !important;" class="px-6 py-4 whitespace-nowrap text-sm">{{ $u->name }}</td>
                            <td style="color: black !important; font-weight: 600 !important; background-color: white !important;" class="px-6 py-4 whitespace-nowrap text-sm">{{ $u->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $u->is_admin ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">{{ $u->is_admin ? 'Yes' : 'No' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('admin.users.update', $u) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="is_admin" value="0">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_admin" value="1" {{ $u->is_admin ? 'checked' : '' }} class="mr-2" {{ auth()->user()->id === $u->id ? 'disabled' : '' }}>
                                            <span class="text-sm">Make admin</span>
                                        </label>

                                        <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-white bg-black hover:bg-gray-800 disabled:opacity-50" {{ auth()->user()->id === $u->id ? 'disabled' : '' }}>Save</button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')

                                        <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-white bg-red-600 hover:bg-red-700 disabled:opacity-50" {{ auth()->user()->id === $u->id ? 'disabled' : '' }}>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
