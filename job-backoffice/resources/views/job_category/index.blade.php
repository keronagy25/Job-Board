<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            {{ request('archived') ? 'Archived Job Categories' : 'Job Categories' }}
        </h2>

        <div class="flex items-center gap-3">

            <a href="{{ route('job-categories.index') }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active
            </a>

            <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Archived
            </a>

            <a href="{{ route('job-categories.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                + Add Category
            </a>

        </div>

    </div>
</x-slot>

<x-successfull-notification />

<div class="py-10 bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white shadow-lg rounded-2xl overflow-hidden">

    <div class="px-6 py-4 border-b bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-700">
            All Categories
        </h3>
    </div>

    <div class="overflow-x-auto p-6">

        @if($jobCategories->isNotEmpty())

        <table class="w-full">

            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

            @foreach($jobCategories as $jobCategory)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $jobCategory->name }}
                    </td>

                    <td class="px-6 py-4 flex gap-3">

                        @if(!request('archived'))

                            <a href="{{ route('job-categories.edit', $jobCategory->id) }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('job-categories.destroy', $jobCategory->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                                    Archive
                                </button>
                            </form>

                        @else

                            <form method="POST"
                                  action="{{ route('job-categories.restore', $jobCategory->id) }}">
                                @csrf

                                <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Restore
                                </button>
                            </form>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        <div class="p-6">
            {{ $jobCategories->links() }}
        </div>

        @else
        <div class="text-center py-10 text-gray-500">
            No Categories Found
        </div>
        @endif

    </div>

</div>

</div>

</div>

</x-app-layout>