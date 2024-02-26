<x-student-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto space-y-4 shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @php
                        // Start and end dates
                        $startDate = Carbon\Carbon::createFromFormat('m/d/Y', $section->start_date );
                        $endDate = Carbon\Carbon::createFromFormat('m/d/Y', $section->end_date );

                        $subjects = $course->subjects;
                        $subCount = count($subjects);

                        // Array to store generated dates
                        $subAttendances = [];
                        $currentDate = now();
                        // Generate dates between start and end dates
                        while ($startDate->lte($endDate)) {

                        foreach ($subjects as $key => $subject) {

                        $asocArr=[];
                        $asocArr['date']=$startDate->format('m/d/Y');
                        $asocArr['start_time']=$subject->start_time;
                        $asocArr['end_time']=$subject->end_time;
                        $asocArr['name']=$subject->name;
                        // Fetch attendance status for this subject and date
                        $attendance = App\Models\Attendance::where('student_id', Auth::user()->student->id)
                        ->where('subject_id', $subject->id)
                        ->whereDate('created_at', $startDate->format('Y-m-d'))
                        ->first();

                        if ($attendance) {
                        $asocArr['status'] = $attendance->is_present ? 'Present' : 'Absent';
                        } else {
                        // Check if the date is in the past
                        if ($startDate->lt($currentDate)) {
                        $asocArr['status'] = 'Absent'; // Mark as absent for past dates without attendance
                        } else {
                        $asocArr['status'] = 'Not Recorded';
                        }

                        }
                        $subAttendances[]= $asocArr;
                        }

                        $startDate->addDay();
                        }

                        @endphp

                        This is attendance

                        <table class="w-full text-sm text-left rtl:text-right ">
                            <thead class="text-sm font-bold uppercase bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Start_Time
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        End_Time
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subAttendances as $subAttendance)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-base">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $subAttendance['date'] }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $subAttendance['start_time'] }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $subAttendance['end_time'] }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $subAttendance['name'] }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $subAttendance['status'] }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
