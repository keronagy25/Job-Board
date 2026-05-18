<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                {{ $jobVacancy->title }}
            </h2>

            <a href="{{ route('job-vacancies.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Back
            </a>

        </div>
    </x-slot>

    <!-- SUCCESS MESSAGE -->
    <x-successfull-notification />

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- TOP SECTION -->
                <div class="p-8 border-b bg-gray-50">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-5">

                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl">
                                {{ strtoupper(substr($jobVacancy->title, 0, 1)) }}
                            </div>

                            <div>

                                <h1 class="text-3xl font-bold text-gray-800">
                                    {{ $jobVacancy->title }}
                                </h1>

                                <p class="text-gray-500 mt-1">
                                    {{ $jobVacancy->type }}
                                </p>

                            </div>

                        </div>

                        <!-- STATUS -->
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                            Active
                        </span>

                    </div>

                </div>

                <!-- DETAILS -->
                <div class="p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- DESCRIPTION -->
                        <div class="md:col-span-2">

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Description
                            </p>

                            <p class="mt-3 text-gray-700 leading-relaxed">
                                {{ $jobVacancy->description }}
                            </p>

                        </div>

                        <!-- LOCATION -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Location
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->location }}
                            </p>

                        </div>

                        <!-- TYPE -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Job Type
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->type }}
                            </p>

                        </div>

                        <!-- SALARY -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Salary
                            </p>

                            <p class="mt-2 text-gray-700">
                                ${{ $jobVacancy->salary }}
                            </p>

                        </div>

                        <!-- VIEW COUNT -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                View Count
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->veiw_count }}
                            </p>

                        </div>

                        <!-- REQUIRED SKILLS -->
                        <div class="md:col-span-2">

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Required Skills
                            </p>

                            <div class="mt-3 flex flex-wrap gap-3">

                                @foreach (explode(',', $jobVacancy->required_skills) as $skill)

                                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                        {{ trim($skill) }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                        <!-- COMPANY -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Company
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->company->name ?? 'N/A' }}
                            </p>

                        </div>

                        <!-- CATEGORY -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Category
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->category->name ?? 'N/A' }}
                            </p>

                        </div>

                        <!-- CREATED -->
                        <div>

                            <p class="text-sm font-semibold text-gray-400 uppercase">
                                Created At
                            </p>

                            <p class="mt-2 text-gray-700">
                                {{ $jobVacancy->created_at->format('d M Y') }}
                            </p>

                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div class="mt-10 flex flex-wrap gap-4 border-t pt-6">

                        <!-- EDIT -->
                        <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                           class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Edit Vacancy
                        </a>

                        <!-- ARCHIVE -->
                        <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                Archive
                            </button>

                        </form>

                    </div>

                    <!-- APPLICATIONS SECTION -->
                    <div x-data="{ openApplications: false }" class="mt-12 border-t pt-8">

                        <!-- BUTTON -->
                        <button
                            @click="openApplications = !openApplications"
                            class="relative pb-3 text-lg font-semibold transition"
                            :class="openApplications
                                ? 'text-blue-600'
                                : 'text-gray-500 hover:text-gray-700'"
                        >

                            Applications

                            <!-- LINE -->
                            <div
                                x-show="openApplications"
                                x-transition
                                class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-full"
                            ></div>

                        </button>

                        <!-- TABLE -->
                        <div x-show="openApplications" x-transition class="mt-6 overflow-x-auto">

                            <table class="w-full border border-gray-200 rounded-xl overflow-hidden">

                                <!-- HEADER -->
                                <thead class="bg-gray-100">

                                    <tr>

                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                            Applicant
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                            Email
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                            Status
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                            Applied At
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <!-- BODY -->
                                <tbody class="divide-y divide-gray-200 bg-white">

                                    @forelse ($jobVacancy->jobApplications as $application)

                                        <tr class="hover:bg-gray-50 transition">

                                            <!-- USER -->
                                            <td class="px-6 py-4">
                                                {{ $application->user->name }}
                                            </td>

                                            <!-- EMAIL -->
                                            <td class="px-6 py-4">
                                                {{ $application->user->email }}
                                            </td>

                                            <!-- STATUS -->
                                            <td class="px-6 py-4">

                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                                    {{ $application->status }}
                                                </span>

                                            </td>

                                            <!-- DATE -->
                                            <td class="px-6 py-4">
                                                {{ $application->created_at->format('d M Y') }}
                                            </td>

                                            <!-- ACTION -->
                                            <td class="px-6 py-4">

                                                <a href="{{ route('job-applications.show', $application->id) }}"
                                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                    Show
                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="5"
                                                class="px-6 py-8 text-center text-gray-500">

                                                No applications found.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    
</x-app-layout>