<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-between p-6 text-gray-900">
                        <div>
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
                        @if (auth()->user()->image)
                        <div
                            class="mt-5 w-[100px] h-[100px] bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                            <img class="object-contain w-full h-full"
                                src="{{ asset('storage/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}">
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mt-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 gap-8 p-6 mt-3 text-gray-900 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($sections as $section)
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h3 class="font-bold">
                                {{ $section->name }}
                            </h3>
                            <p>
                                {{ $section->description ?? "---" }}
                            </p>
                            <ul class="my-3">
                                <li>Start date: {{ $section->start_date }}</li>
                                <li>End date: {{ $section->end_date }}</li>
                                <li>Totoal Students: {{ $section->students->count() }}</li>
                            </ul>
                            <a href="{{ route('a.dashboard.view-section', ['sectionId' => $section->id]) }}"
                                class="font-medium text-blue-600 hover:underline">View detail</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>