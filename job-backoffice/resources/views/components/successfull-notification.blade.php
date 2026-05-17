    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8"
        >
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow flex items-center justify-between">

                <span>
                    {{ session('success') }}
                </span>

                <button @click="show = false" class="text-green-700 font-bold">
                    ✕
                </button>

            </div>
        </div>
    @endif