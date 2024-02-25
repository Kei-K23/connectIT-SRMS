<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h2 class="mb-5 text-xl font-bold text-center">Register new subject</h2>
                    @if (session('success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('success') }}</span>
                    </div>
                    @endif
                    <form class="max-w-md mx-auto space-y-3" method="POST" action="{{ route('a.dashboard.add-subject.store') }}
                    ">
                        @csrf
                        <div class="w-full">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                            <input value="{{ old('name') }}" type="text" name="name" id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Subject name" required>
                            @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
                            <input value="{{ old('description') }}" type="text" name="description" id="description"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Description" required>
                            @error('description')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900">Course</label>
                            <select id="course_id" name="course_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">

                                @foreach ($courses as $course)
                                <option {{ old('course_id')==$course->id ? 'selected' : '' }}
                                    value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center w-full">
                            <div class="relative">
                                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900">Start
                                    time</label>
                                <select id="start_time" name="start_time"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <?php
                                    // Loop through hours
                                    for ($hour = 0; $hour < 24; $hour++) {
                                        for ($minute = 0; $minute < 60; $minute += 15) {
                                            $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                            $minuteStr = str_pad($minute, 2, '0', STR_PAD_LEFT);

                                            echo "<option value='$hourStr:$minuteStr:00'>$hourStr:$minuteStr:00</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                @error('start_time')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <span class="mx-4 text-gray-500">to</span>
                            <div class="relative">
                                <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900">End
                                    time</label>
                                <select id="end_time" name="end_time"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <?php
                                    // Loop through hours
                                    for ($hour = 0; $hour < 24; $hour++) {
                                        for ($minute = 0; $minute < 60; $minute += 15) {
                                            $hourStr = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                            $minuteStr = str_pad($minute, 2, '0', STR_PAD_LEFT);

                                            echo "<option value='$hourStr:$minuteStr:00'>$hourStr:$minuteStr:00</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                @error('end_time')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>