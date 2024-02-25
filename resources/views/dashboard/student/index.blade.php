<x-student-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto space-y-4 shadow-md sm:rounded-lg">
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
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold">
                            {{ $section->name }}
                        </h2>
                        <p>
                            {{ $section->description }}
                        </p>


                        @if(session('success'))
                        <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                            role="alert">
                            <span class="font-medium text-center">{{ session('success') }}</span>
                        </div>
                        @endif

                        <h2 class="mt-4 text-lg font-bold">Subjects</h2>
                        <div class="grid grid-cols-1 gap-8 mt-3 lg:grid-cols-3">
                            @foreach ($section->course->subjects as $subject)
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <h2 class="mb-2 text-lg font-bold">
                                    {{ $subject->name }}
                                </h2>
                                <p class="mb-1">{{ $subject->description ?? '...' }}</p>
                                @php
                                $carbonTimeForStartTime = Carbon\Carbon::createFromFormat('H:i:s',
                                $subject->start_time);
                                $carbonTimeForEndTime = Carbon\Carbon::createFromFormat('H:i:s', $subject->end_time);
                                $startTime = $carbonTimeForStartTime->format('g A');
                                $endTime = $carbonTimeForEndTime->format('g A');
                                @endphp
                                <p>Start : {{ $startTime }}</p>
                                <p>End : {{ $endTime }}</p>
                                <form action="{{ route('s.dashboard.attendance.store') }}" method="post" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="is_present" value="true">
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <input type="hidden" name="student_id" value="{{ auth()->user()->student->id }}">
                                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                                    <button type="submit"
                                        class="p-2 font-semibold transition-colors rounded-lg cursor-pointer bg-slate-400 hover:bg-slate-300 active:bg-slate-500">Make
                                        as done</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>