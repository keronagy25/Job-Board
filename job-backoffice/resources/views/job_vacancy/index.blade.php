<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            {{ request('archived') ? 'Archived Job Vacancies' : 'Job Vacancies' }}
        </h2>

        <div class="flex items-center gap-3">

            {{-- ACTIVE --}}
            <a href="{{ route('job-vacancies.index') }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active
            </a>

            {{-- ARCHIVED --}}
            <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Archived
            </a>

            {{-- CREATE --}}
            @if(!request('archived'))
                <a href="{{ route('job-vacancies.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    + Add Vacancy
                </a>
            @endif

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
            All Job Vacancies
        </h3>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Title</th>
                    <th class="px-6 py-4 text-left">Description</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

            @forelse($jobVacancies as $job)

                <tr class="hover:bg-gray-50">

                    {{-- TITLE --}}
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $job->title }}
                    </td>

                    {{-- DESCRIPTION --}}
                    <td class="px-6 py-4 text-gray-600">
                        {{ Str::limit($job->description, 80) }}
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-6 py-4 flex gap-2">

                        @if(!$job->trashed())

                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Show
                            </a>

                            <a href="{{ route('job-vacancies.edit', $job->id) }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('job-vacancies.destroy', $job->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                                    Archive
                                </button>
                            </form>

                        @else

                            <form method="POST"
                                  action="{{ route('job-vacancies.restore', $job->id) }}">
                                @csrf

                                <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Restore
                                </button>
                            </form>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="3" class="text-center py-10 text-gray-500">
                        No Job Vacancies Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="p-6">
        {{ $jobVacancies->links() }}
    </div>

</div>

</div>

</div>

</x-app-layout>