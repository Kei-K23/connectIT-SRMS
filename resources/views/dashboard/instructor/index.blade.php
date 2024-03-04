<x-instructor-layout>
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
                <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm sm:rounded-lg">

                    <h2 class="text-xl font-bold">
                        {{ $user->instructor->section->name }}
                    </h2>
                    <p>
                        {{ $user->instructor->section->description }}
                    </p>
                </div>
                <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm sm:rounded-lg">
                    <h2 class="text-xl font-bold text-center">Upload course material</h2>
                    @if(session('success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-red-800 rounded-lg bg-red-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('error') }}</span>
                    </div>
                    @endif

                    <form class="max-w-md mx-auto space-y-3" method="POST" action="{{ route('materials.store') }}"
                        enctype="multipart/form-data">
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
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 ">file</label>
                            <input value="{{ old('file') }}" type="file" name="file" id="file"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="file" required>
                            @error('file')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <input type="hidden" value="{{ $user->instructor->section->id }}" name="section_id">
                        <input type="hidden" value="{{ $user->instructor->id }}" name="instructor_id">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Upload</button>
                    </form>
                </div>
            </div>
        </div>
</x-instructor-layout>