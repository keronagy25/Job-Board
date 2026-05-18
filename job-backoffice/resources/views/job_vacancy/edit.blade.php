<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                Edit Job Vacancy
            </h2>

            <a href="{{ route('job-vacancies.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Back
            </a>

        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl p-8">

                <form action="{{ route('job-vacancies.update', $jobVacancy->id) }}"
                      method="POST"
                      class="space-y-10">

                    @csrf
                    @method('PUT')

                    <!-- JOB DETAILS -->
                    <div>

                        <h3 class="text-xl font-bold text-gray-700 border-b pb-2 mb-6">
                            Job Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- TITLE -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>

                                <input type="text" name="title"
                                       value="{{ old('title', $jobVacancy->title) }}"
                                       class="mt-1 w-full border rounded-lg p-2
                                       @error('title') border-red-500 @else border-gray-300 @enderror">

                                @error('title')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TYPE -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type</label>

                                <select name="type"
                                        class="mt-1 w-full border rounded-lg p-2
                                        @error('type') border-red-500 @else border-gray-300 @enderror">

                                    <option value="">Select Type</option>

                                    @foreach (['Full-time','Hybrid','Contract','Remote'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('type', $jobVacancy->type) == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('type')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- LOCATION -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>

                                <input type="text" name="location"
                                       value="{{ old('location', $jobVacancy->location) }}"
                                       class="mt-1 w-full border rounded-lg p-2
                                       @error('location') border-red-500 @else border-gray-300 @enderror">

                                @error('location')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SALARY -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Salary</label>

                                <input type="number" name="salary"
                                       value="{{ old('salary', $jobVacancy->salary) }}"
                                       class="mt-1 w-full border rounded-lg p-2
                                       @error('salary') border-red-500 @else border-gray-300 @enderror">

                                @error('salary')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- COMPANY -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company</label>

                                <select name="companyId"
                                        class="mt-1 w-full border rounded-lg p-2
                                        @error('companyId') border-red-500 @else border-gray-300 @enderror">

                                    <option value="">Select Company</option>

                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('companyId')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CATEGORY -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>

                                <select name="categoryId"
                                        class="mt-1 w-full border rounded-lg p-2
                                        @error('categoryId') border-red-500 @else border-gray-300 @enderror">

                                    <option value="">Select Category</option>

                                    @foreach ($jobcategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('categoryId', $jobVacancy->categoryId) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('categoryId')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- REQUIRED SKILLS -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Required Skills
                                </label>

                                <input type="text" name="required_skills"
                                       value="{{ old('required_skills', $jobVacancy->required_skills) }}"
                                       class="mt-1 w-full border rounded-lg p-2
                                       @error('required_skills') border-red-500 @else border-gray-300 @enderror">

                                @error('required_skills')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>

                                <textarea name="description" rows="5"
                                          class="mt-1 w-full border rounded-lg p-2
                                          @error('description') border-red-500 @else border-gray-300 @enderror">{{ old('description', $jobVacancy->description) }}</textarea>

                                @error('description')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <div>
                        <button type="submit"
                                class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 transition font-semibold">
                            Update Job Vacancy
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>