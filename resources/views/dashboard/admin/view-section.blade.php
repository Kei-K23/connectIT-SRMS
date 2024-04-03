<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-5">

                        <a href="{{ route('a.dashboard') }}" class="font-medium text-blue-600 hover:underline">Back to
                            Dashboard</a>

                        <div class="mt-4">
                            <h1 class="text-3xl font-bold">
                                {{ $section->name }}
                            </h1>
                            <p class="text-lg">
                                {{$section->description}}
                            </p>
                            <h2 class="my-3 text-xl font-bold">Section information</h2>
                            <ul class="max-w-md mt-2 space-y-1 list-disc list-inside ">
                                <li>
                                    Section fee: <b>
                                        {{ $section->course->fee }} $</b>
                                </li>
                                <li>
                                    Duration: <b>
                                        {{ $section->course->duration }}</b>
                                </li>
                                <li>
                                    Start date: <b>
                                        {{ $section->start_date }}</b>
                                </li>
                                <li>
                                    End date: <b>
                                        {{ $section->end_date }}</b>
                                </li>
                                <li>
                                    Total Students: <b>
                                        {{ $section->students->count() }}</b>
                                </li>
                            </ul>
                            <table class="w-full mt-10 text-sm text-left rtl:text-right ">
                                <thead class="text-sm font-bold uppercase bg-gray-50 ">

                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Student ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            -
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section->students as $student)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-base">
                                            {{ $student->id }}
                                        </td>
                                        <td class="px-6 py-4 text-base">
                                            {{ $student->user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-base">
                                            {{ $student->user->email }}
                                        </td>
                                        <td class="px-6 py-4 text-base">
                                            <a href="{{ route('a.dashboard.view-student-attendance' , ['sectionId' => $section->id, 'student' => $student]) }}"
                                                class="font-medium text-blue-600 hover:underline">View
                                                attendance</a>
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
    </div>
</x-admin-layout>