<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            {{ request('archived') ? 'Archived Job Applications' : 'Job Applications' }}
        </h2>

        <div class="flex items-center gap-3">

            <a href="{{ route('job-applications.index') }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active
            </a>

            <a href="{{ route('job-applications.index', ['archived' => 'true']) }}"
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

    <div class="px-6 py-4 border-b bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-700">
            {{ request('archived') ? 'Archived Applications' : 'Active Applications' }}
        </h3>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">Applicant</th>
                    <th class="px-6 py-4 text-left">Job</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">AI Score</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

            @forelse ($jobApplications as $application)

                <tr class="hover:bg-gray-50">

                    <td class="px-6 py-4">
                        {{ $application->user->name ?? 'N/A' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $application->jobVacancy->title ?? 'N/A' }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($application->status === 'accepted')
                                bg-green-100 text-green-700
                            @elseif($application->status === 'rejected')
                                bg-red-100 text-red-700
                            @else
                                bg-yellow-100 text-yellow-700
                            @endif">
                            {{ $application->status }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        {{ $application->aiGeneratedScore ?? 'N/A' }}
                    </td>

                    <td class="px-6 py-4 flex gap-2">

                        {{-- ACTIVE MODE: Show + Edit + Archive --}}
                        @if(!request('archived'))

                            <a href="{{ route('job-applications.show', $application->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Show
                            </a>

                            <a href="{{ route('job-applications.edit', $application->id) }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('job-applications.destroy', $application->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                                    Archive
                                </button>
                            </form>

                        @else

                            {{-- ARCHIVED MODE: Restore only --}}
                            <form method="POST"
                                  action="{{ route('job-applications.restore', $application->id) }}">
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
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        No applications found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
        {{-- PAGINATION --}}
    <div class="p-6">
        {{ $jobApplications->links() }}
    </div>

</div>

</div>

</div>

</x-app-layout>