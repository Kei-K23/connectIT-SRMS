<x-instructor-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @php
                        $currentTime = date('H');
                        $greeting = '';
                        if ($currentTime < 12) { $greeting='Good morning' ; } elseif ($currentTime < 17) {
                            $greeting='Good afternoon' ; } else { $greeting='Good evening' ; } @endphp <h1
                            class="text-xl font-bold md:text-2xl lg:text-3xl">
                            {{ $greeting }}, {{ auth()->user()->name }} 👋
                            </h1>
                            <p class="text-lg text-slate-500">
                                Here is what’s happening with your projects today:
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-instructor-layout>