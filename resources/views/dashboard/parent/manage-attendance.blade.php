<x-parent-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto space-y-4 shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="mb-8">
                            <h2 class="mb-4 text-xl font-bold">
                                Student name: {{ Auth::user()->guardian->student->user->name }}
                            </h2>
                            <h3 class="text-base font-bold">
                                Course Name: {{ $course->name }}
                            </h3>
                            <h3 class="text-base font-bold">
                                Section Name: {{ $section->name }}
                            </h3>
                            <h3 class="text-base font-bold">
                                Present: {{ $attendances->count() }}
                            </h3>
                        </div>

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
</x-parent-layout>