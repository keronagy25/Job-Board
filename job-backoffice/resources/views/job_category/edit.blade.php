<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Update Category
                    </h3>
                    <p class="text-sm text-gray-500">
                        Modify the job category details below.
                    </p>
                </div>

                <!-- Form -->
                <div class="p-6">

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('job-categories.update', $jobCategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-2">
                                Category Name
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $jobCategory->name) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter category name">
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between">

                            <a href="{{ route('job-categories.index') }}"
                               class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                Update Category
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>