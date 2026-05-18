<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                {{ request('archived') ? __('Archived Job Vacancies') : __('Job Vacancies') }}
            </h2>

            <div class="flex items-center gap-3">

                <!-- ACTIVE -->
                <a href="{{ route('job-vacancies.index') }}"
                   class="px-4 py-2 rounded-lg shadow transition
                   {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Active
                </a>

                <!-- ARCHIVED -->
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}"
                   class="px-4 py-2 rounded-lg shadow transition
                   {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Archived
                </a>

                <!-- CREATE -->
                <a href="{{ route('job-vacancies.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    + Add Vacancy
                </a>

            </div>

        </div>
    </x-slot>

    <!-- SUCCESS -->
    <x-successfull-notification />

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- HEADER -->
                <div class="px-6 py-4 border-b bg-gray-50">

                    <h3 class="text-lg font-semibold text-gray-700">
                        All Job Vacancies
                    </h3>

                    <p class="text-sm text-gray-500">
                        Manage all vacancies easily.
                    </p>

                </div>

                <!-- CONTENT -->
                <div class="p-6">

                    @if ($jobVacancies->isNotEmpty())

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            @foreach ($jobVacancies as $job)

                                <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg transition duration-300">

                                    <!-- TOP -->
                                    <div class="flex items-start justify-between">

                                        <div>

                                            <h3 class="text-xl font-bold text-gray-800">
                                                {{ $job->title }}
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-2 line-clamp-3">
                                                {{ $job->description }}
                                            </p>

                                        </div>
                                    </div>

                                    <!-- ACTIONS -->
                                    <div class="mt-6 flex flex-wrap gap-3">

                                        @if (!$job->trashed())

                                            <!-- SHOW -->
                                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                               class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                Show
                                            </a>

                                            <!-- EDIT -->
                                            <a href="{{ route('job-vacancies.edit', $job->id) }}"
                                               class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                                Edit
                                            </a>

                                            <!-- ARCHIVE -->
                                            <form action="{{ route('job-vacancies.destroy', $job->id) }}"
                                                  method="POST"
                                                  class="flex-1">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                    Archive
                                                </button>

                                            </form>

                                        @else

                                            <!-- RESTORE -->
                                            <form action="{{ route('job-vacancies.restore', $job->id) }}"
                                                  method="POST"
                                                  class="flex-1">

                                                @csrf

                                                <button type="submit"
                                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                    Restore
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        <!-- PAGINATION -->
                        <div class="mt-8">
                            {{ $jobVacancies->links() }}
                        </div>

                    @else

                        <div class="text-center py-16">

                            <h3 class="text-2xl font-bold text-gray-700">
                                No Job Vacancies Found
                            </h3>

                            <p class="text-gray-500 mt-2">
                                Start by adding a new vacancy.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>