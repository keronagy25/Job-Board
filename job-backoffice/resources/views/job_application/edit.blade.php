<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                Edit Application Status
            </h2>

            <a href="{{ route('job-applications.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Back
            </a>

        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 👤 APPLICANT INFO CARD --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <div class="p-6 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Applicant Information
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm text-gray-400">Applicant Name</p>
                        <p class="text-gray-800 font-medium">
                            {{ $jobApplication->user->name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Email</p>
                        <p class="text-gray-800">
                            {{ $jobApplication->user->email ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Job Title</p>
                        <p class="text-gray-800">
                            {{ $jobApplication->jobVacancy->title ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">AI Score</p>
                        <p class="text-gray-800 font-semibold">
                            {{ $jobApplication->aiGeneratedScore ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-400">AI Feedback</p>
                        <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700">
                            {{ $jobApplication->aiGeneratedFeedback ?? 'No feedback available' }}
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Status</p>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
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

                </div>
            </div>

            {{-- ✏️ EDIT FORM --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <div class="p-6 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Update Status Only
                    </h3>
                </div>

                <form method="POST"
                      action="{{ route('job-applications.update', $jobApplication->id) }}"
                      class="p-6 space-y-6">

                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Change Status
                        </label>

                        <select name="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">

                            <option value="pending"
                                {{ $jobApplication->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="accepted"
                                {{ $jobApplication->status === 'accepted' ? 'selected' : '' }}>
                                Accepted
                            </option>

                            <option value="rejected"
                                {{ $jobApplication->status === 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                        </select>
                    </div>

                    <div class="flex justify-end gap-3">

                        <a href="{{ route('job-applications.index') }}"
                           class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>