<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            {{ request('archived') ? __('Archived Job Categories') : __('Job Categories') }}
        </h2>

        <div class="flex items-center gap-3">

            <!-- Toggle: All -->
            <a href="{{ route('job-categories.index') }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active
            </a>

            <!-- Toggle: Archived -->
            <a href="{{ route('job-categories.index', ['archived' => 'true']) }}"
               class="px-4 py-2 rounded-lg shadow transition
               {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Archived
            </a>

            <!-- Add Button -->
            <a href="{{ route('job-categories.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                + Add Category
            </a>

        </div>
    </div>
</x-slot>

    <!-- SUCCESS MESSAGE -->
    <x-successfull-notification />


    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

                <!-- HEADER -->
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700">
                        All Categories
                    </h3>
                    <p class="text-sm text-gray-500">
                        Manage all job categories easily.
                    </p>
                </div>

                <!-- CONTENT -->
                <div class="p-6">

                    @if ($jobCategories->isNotEmpty())

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                            @foreach ($jobCategories as $jobCategory)

                                <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg transition duration-300">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <h4 class="text-lg font-bold text-gray-800">
                                                {{ $jobCategory->name }}
                                            </h4>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Job category
                                            </p>
                                        </div>

                                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-lg">
                                            {{ strtoupper(substr($jobCategory->name, 0, 1)) }}
                                        </div>

                                    </div>

                                            <!-- ACTIONS -->
                                    <div class="mt-5 flex gap-3">

                                        @if (!request('archived'))

                                            <!-- ACTIVE STATE -->

                                            <a href="{{ route('job-categories.edit', $jobCategory->id) }}"
                                            class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('job-categories.destroy', $jobCategory->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                    Archive
                                                </button>
                                            </form>

                                        @else

                                            <!-- ARCHIVED STATE -->

                                            <form action="{{ route('job-categories.restore', $jobCategory->id) }}" method="POST" class="w-full">
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
                        <div class="mt-6 flex justify-center">
                            {{ $jobCategories->links() }}
                        </div>

                    @else

                        <div class="text-center py-12">
                            <h3 class="text-xl font-semibold text-gray-700">
                                No Categories Found
                            </h3>

                            <p class="text-gray-500 mt-2">
                                Start by adding a new job category.
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>