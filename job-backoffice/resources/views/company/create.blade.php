<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-bold text-2xl text-gray-800">
                Create Company
            </h2>

            <a href="{{ route('companies.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                Back
            </a>

        </div>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-2xl p-8">

                <form action="{{ route('companies.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- COMPANY --}}
                    <div>
                        <h3 class="text-xl font-bold border-b pb-2 mb-4">Company Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- NAME --}}
                            <div>
                                <label>Company Name</label>
                                <input type="text" name="name"
                                       value="{{ old('name') }}"
                                       class="w-full mt-1 border rounded-lg p-2
                                       @error('name') border-red-500 @enderror">

                                @error('name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- INDUSTRY --}}
                            <div>
                                <label>Industry</label>
                                <select name="industry"
                                        class="w-full mt-1 border rounded-lg p-2
                                        @error('industry') border-red-500 @enderror">

                                    <option value="">Select Industry</option>

                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry }}"
                                            {{ old('industry') == $industry ? 'selected' : '' }}>
                                            {{ $industry }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('industry')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- ADDRESS --}}
                            <div class="md:col-span-2">
                                <label>Address</label>
                                <input type="text" name="address"
                                       value="{{ old('address') }}"
                                       class="w-full mt-1 border rounded-lg p-2
                                       @error('address') border-red-500 @enderror">

                                @error('address')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- WEBSITE --}}
                            <div class="md:col-span-2">
                                <label>Website (Optional)</label>
                                <input type="url" name="website"
                                       value="{{ old('website') }}"
                                       class="w-full mt-1 border rounded-lg p-2
                                       @error('website') border-red-500 @enderror">

                                @error('website')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- OWNER --}}
                    <div>
                        <h3 class="text-xl font-bold border-b pb-2 mb-4">Owner Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- OWNER NAME --}}
                            <div>
                                <label>Owner Name</label>
                                <input type="text" name="owner_name"
                                       value="{{ old('owner_name') }}"
                                       class="w-full mt-1 border rounded-lg p-2
                                       @error('owner_name') border-red-500 @enderror">

                                @error('owner_name')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- OWNER EMAIL --}}
                            <div>
                                <label>Owner Email</label>
                                <input type="email" name="owner_email"
                                       value="{{ old('owner_email') }}"
                                       class="w-full mt-1 border rounded-lg p-2
                                       @error('owner_email') border-red-500 @enderror">

                                @error('owner_email')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- OWNER PASSWORD --}}
                            <div class="md:col-span-2" x-data="{ show: false }">
                                <label>Owner Password</label>

                                <div class="relative mt-1">
                                    <input :type="show ? 'text' : 'password'"
                                           name="owner_password"
                                           class="w-full border rounded-lg p-2 pr-10
                                           @error('owner_password') border-red-500 @enderror">

                                    <button type="button"
                                            @click="show = !show"
                                            class="absolute right-3 top-2.5 text-gray-500">
                                        👁
                                    </button>
                                </div>

                                @error('owner_password')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="pt-6 mt-0">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                            Create Company
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>