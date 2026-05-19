<x-app-layout>

<x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="font-bold text-2xl text-gray-800">
            Edit User
        </h2>

        <a href="{{ route('users.index') }}"
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Back
        </a>

    </div>
</x-slot>

<div class="py-10 bg-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-700">
                    Update User (Name & Password Only)
                </h3>
            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('users.update', $user->id) }}"
                  class="p-6 space-y-6">

                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ $user->name }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                           required>
                </div>

                {{-- EMAIL (LOCKED) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email (cannot be changed)
                    </label>

                    <input type="email"
                           value="{{ $user->email }}"
                           disabled
                           class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>

                {{-- ROLE (LOCKED) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Role (cannot be changed)
                    </label>

                    <input type="text"
                           value="{{ $user->role }}"
                           disabled
                           class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>

                {{-- PASSWORD --}}
                <div x-data="{ show: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        New Password (optional)
                    </label>

                    <div class="relative">

                        <input :type="show ? 'text' : 'password'"
                               name="password"
                               placeholder="Leave empty if not changing password"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 pr-10">

                        {{-- EYE ICON --}}
                        <button type="button"
                                @click="show = !show"
                                class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700">

                            👁️

                        </button>

                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex justify-end gap-3">

                    <a href="{{ route('users.index') }}"
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