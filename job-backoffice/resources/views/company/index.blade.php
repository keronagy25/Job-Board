<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                {{ request('archived') ? 'Archived Companies' : 'Companies' }}
            </h2>

            <div class="flex items-center gap-3">

                {{-- ACTIVE --}}
                <a href="{{ route('companies.index') }}"
                   class="px-4 py-2 rounded-lg shadow transition
                   {{ !request('archived') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Active
                </a>

                {{-- ARCHIVED --}}
                <a href="{{ route('companies.index', ['archived' => 'true']) }}"
                   class="px-4 py-2 rounded-lg shadow transition
                   {{ request('archived') ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Archived
                </a>

                {{-- ADD --}}
                @if(!request('archived'))
                    <a href="{{ route('companies.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        + Add Company
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
                        Company List
                    </h3>
                </div>

                {{-- CONTENT --}}
                <div class="p-6">

                    @if ($companies->isNotEmpty())

                        <div class="space-y-4">

                            @foreach ($companies as $company)

                                <div class="flex items-center justify-between border rounded-xl p-5 bg-white">

                                    {{-- LEFT --}}
                                    <div class="flex items-center gap-4">

                                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                            {{ strtoupper(substr($company->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">
                                                {{ $company->name }}
                                            </h3>

                                            <p class="text-sm text-gray-500">
                                                {{ request('archived') ? 'Archived Company' : 'Active Company' }}
                                            </p>
                                        </div>

                                    </div>

                                    {{-- ACTIONS --}}
                                    <div class="flex items-center gap-3">

                                        {{-- ACTIVE MODE --}}
                                        @if(!request('archived'))

                                            {{-- VIEW --}}
                                            <a href="{{ route('companies.show', $company->id) }}"
                                               class="text-blue-600 hover:underline">
                                                View
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('companies.edit', $company->id) }}"
                                               class="text-yellow-600 hover:underline">
                                                Edit
                                            </a>

                                            {{-- ARCHIVE (SOFT DELETE) --}}
                                            <form action="{{ route('companies.destroy', $company->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to archive this company?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600 hover:underline">
                                                    Archive
                                                </button>
                                            </form>

                                        @else

                                            {{-- RESTORE --}}
                                            <form action="{{ route('companies.restore', $company->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Restore this company?')">
                                                @csrf

                                                <button type="submit"
                                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                    Restore
                                                </button>
                                            </form>

                                        @endif

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- PAGINATION --}}
                        <div class="mt-8 flex justify-center">
                            {{ $companies->links() }}
                        </div>

                    @else

                        <div class="text-center py-16">

                            <h3 class="text-2xl font-bold text-gray-700">
                                No Companies Found
                            </h3>

                            <p class="text-gray-500 mt-3">
                                Start by adding your first company.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>