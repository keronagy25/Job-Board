<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800">
                Application Details
            </h2>
            <a href="{{ route('job-applications.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- TOP SECTION -->
                <div class="p-8 border-b bg-gray-50 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            {{ $jobApplication->user->name ?? 'Applicant' }}
                        </h1>
                        <p class="text-gray-500 mt-1">
                            {{ $jobApplication->jobVacancy->title ?? 'Job Vacancy' }}
                        </p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($jobApplication->status === 'accepted')
                            bg-green-100 text-green-700
                        @elseif($jobApplication->status === 'rejected')
                            bg-red-100 text-red-700
                        @else
                            bg-yellow-100 text-yellow-700
                        @endif">
                        {{ $jobApplication->status }}
                    </span>
                </div>

                <!-- DETAILS SECTION -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm text-gray-400">Applicant</p>
                        <p class="text-gray-700">{{ $jobApplication->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-gray-700">{{ $jobApplication->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Job Vacancy</p>
                        <p class="text-gray-700">{{ $jobApplication->jobVacancy->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">AI Score</p>
                        <p class="text-gray-700">{{ $jobApplication->aiGeneratedScore ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-400">AI Feedback</p>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                            {{ $jobApplication->aiGeneratedFeedback ?? 'No feedback available' }}
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Resume</p>
                        <p class="text-gray-700">{{ $jobApplication->resume->fileUri ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Applied At</p>
                        <p class="text-gray-700">
                            {{ $jobApplication->created_at->format('d M Y h:i A') }}
                        </p>
                    </div>
                </div>

                <!-- ACTIONS - RIGHT ALIGNED -->
                <div class="px-8 pb-8 pt-6 border-t flex justify-end gap-4">
                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}"
                       class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-5 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Archive
                        </button>
                    </form>
                </div>

                <!-- RESUME TAB -->
                <div x-data="{ open: false }" class="border-t px-8 py-6">
                    <button @click="open = !open"
                        class="text-lg font-semibold text-gray-700 hover:text-blue-600 transition relative">
                        Resume Details
                        <div x-show="open" x-transition class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-full"></div>
                    </button>

                    @php $resume = $jobApplication->resume; @endphp

                    <div x-show="open" x-transition class="mt-6">
                        @if($resume)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-5 rounded-xl border">
                                    <h3 class="font-semibold text-gray-700 mb-2">Summary</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $resume->summary ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-xl border">
                                    <h3 class="font-semibold text-gray-700 mb-2">Skills</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $resume->skills ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-xl border md:col-span-2">
                                    <h3 class="font-semibold text-gray-700 mb-2">Experience</h3>
                                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $resume->experience ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-xl border">
                                    <h3 class="font-semibold text-gray-700 mb-2">Education</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $resume->education ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-xl border">
                                    <h3 class="font-semibold text-gray-700 mb-2">Contact Details</h3>
                                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $resume->contactDetails ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-10 text-gray-500">No resume found for this application.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>