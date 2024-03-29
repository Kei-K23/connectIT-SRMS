<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h2 class="mb-5 text-xl font-bold text-center">Register new course</h2>
                    @if(session('success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('success') }}</span>
                    </div>
                    @endif
                    <form class="max-w-md mx-auto space-y-3" method="POST" action="{{ route('a.dashboard.add-course.store') }}
                    ">
                        @csrf
                        <div class="w-full">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                            <input value="{{ old('name') }}" type="text" name="name" id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Course name" required>
                            @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Duration</label>
                            <select id="duration" name="duration"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                @for ($d = 1; $d <= 12; $d++) <option value="{{ $d }} months" {{ old('duration')==$d
                                    ? 'selected' : '' }}>{{ $d }} months
                                    </option>
                                    @endfor
                            </select>
                            @error('duration')
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
                            <label for="fee" class="block mb-2 text-sm font-medium text-gray-900 ">fee</label>
                            <input value="{{ old('fee') }}" type="number" name="fee" id="fee"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="fee" required>
                            @error('fee')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>