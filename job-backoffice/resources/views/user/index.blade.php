<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            {{ request('archived') ? 'Archived Users' : 'Active Users' }}
        </h2>

        {{-- ACTIVE / ARCHIVED TOGGLE --}}
        <div class="flex items-center gap-3">

            <a href="{{ route('users.index') }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active
            </a>

            <a href="{{ route('users.index', ['archived' => 'true']) }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Archived
            </a>

        </div>

    </div>
</x-slot>
<x-successfull-notification />
<div class="py-10 bg-gray-100 min-h-screen">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-700">
                    {{ request('archived') ? 'Archived Users' : 'All Users' }}
                </h3>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Role</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                    @forelse ($users as $user)

                        <tr class="hover:bg-gray-50">

                            {{-- NAME --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $user->name }}
                            </td>

                            {{-- EMAIL --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            {{-- ROLE --}}
                            <td class="px-6 py-4">

                                @if($user->role === 'admin')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Admin
                                    </span>

                                @elseif($user->role === 'company-owner')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Company Owner
                                    </span>

                                @elseif($user->role === 'job-seeker')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        Job Seeker
                                    </span>

                                @else
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $user->role }}
                                    </span>
                                @endif

                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 flex gap-2">

                                {{-- ARCHIVED MODE --}}
                                @if(request('archived'))

                                    {{-- admin cannot be restored or touched --}}
                                    @if($user->role !== 'admin')

                                        <form method="POST"
                                              action="{{ route('users.restore', $user->id) }}">
                                            @csrf

                                            <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                                Restore
                                            </button>
                                        </form>

                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                                            Protected Admin
                                        </span>
                                    @endif

                                @else

                                    {{-- ACTIVE MODE --}}

                                    @if($user->role !== 'admin')

                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button class="px-3 py-1 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                                                Archive
                                            </button>
                                        </form>

                                    @else

                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                                            Admin Protected
                                        </span>

                                    @endif

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $users->links() }}
                    </div>

            </div>

        </div>

    </div>

</div>

</x-app-layout>