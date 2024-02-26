<x-student-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto space-y-4 shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="mb-8">
                            <h2 class="mb-4 text-xl font-bold">
                                {{ Auth::user()->name }}
                            </h2>
                            <h3 class="text-base font-bold">
                                Course Name: {{ $course->name }}
                            </h3>
                            <h3 class="text-base font-bold">
                                Section Name: {{ $section->name }}
                            </h3>
                        </div>

                        <table class="w-full text-sm text-left rtl:text-right ">
                            <thead class="text-sm font-bold uppercase bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Mark
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Subject_Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created_At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-base">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->name }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->description }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->status }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->mark }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->subject->name }}
                                    </td>
                                    <td class="px-6 py-4 text-base">
                                        {{ $report->created_at->diffForHumans() }}
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
