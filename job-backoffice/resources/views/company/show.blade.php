<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800">
                {{ $company->name }}
            </h2>
            <a href="{{ route('companies.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Back
            </a>
        </div>
    </x-slot>

    <x-successfull-notification />

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- TOP SECTION -->
                <div class="p-8 border-b bg-gray-50">
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl">
                            {{ strtoupper(substr($company->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $company->name }}</h1>
                            <p class="text-gray-500 mt-1">{{ $company->industry }}</p>
                        </div>
                    </div>
                </div>

                <!-- DETAILS SECTION -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase">Address</p>
                            <p class="mt-2 text-gray-700">{{ $company->address }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase">Website</p>
                            <a href="{{ $company->website }}" target="_blank" class="mt-2 inline-block text-blue-600 hover:underline break-all">
                                {{ $company->website }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase">Owner</p>
                            <p class="mt-2 text-gray-700">{{ $company->owner->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase">Created At</p>
                            <p class="mt-2 text-gray-700">{{ $company->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- ACTIONS - RIGHT ALIGNED -->
                    @if (!$company->trashed())
                        <div class="mt-10 flex justify-end gap-4 border-t pt-6">
                            <a href="{{ route('companies.edit', $company->id) }}"
                               class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                Edit Company
                            </a>
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                    Archive
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- TABS SECTION -->
                <div x-data="{ tab: 'jobs' }" class="p-8 border-t">
                    <div class="flex gap-10 border-b mb-6">
                        <button @click="tab = 'jobs'"
                            class="pb-3 text-lg font-semibold relative transition"
                            :class="tab === 'jobs' ? 'text-blue-600' : 'text-gray-500 hover:text-gray-700'">
                            Jobs
                            <div x-show="tab === 'jobs'" class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-full"></div>
                        </button>
                        <button @click="tab = 'applications'"
                            class="pb-3 text-lg font-semibold relative transition"
                            :class="tab === 'applications' ? 'text-blue-600' : 'text-gray-500 hover:text-gray-700'">
                            Applications
                            <div x-show="tab === 'applications'" class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-full"></div>
                        </button>
                    </div>

                    <!-- JOBS TABLE -->
                    <div x-show="tab === 'jobs'" x-transition>
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($company->jobVacancies as $job)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $job->title }}</td>
                                        <td class="px-6 py-4">{{ $job->type }}</td>
                                        <td class="px-6 py-4">${{ $job->salary }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                               class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                Show
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- APPLICATIONS TABLE -->
                    <div x-show="tab === 'applications'" x-transition>
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($company->jobApplications as $application)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $application->user->name }}</td>
                                        <td class="px-6 py-4">{{ $application->jobVacancy->title }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                                {{ $application->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('job-applications.show', $application->id) }}"
                                               class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                Show
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No applications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>