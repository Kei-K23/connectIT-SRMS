<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto shadow-md sm:rounded-lg">
                <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <h2 class="mb-5 text-xl font-bold text-center">Register new student</h2>
                    @if(session('success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('success') }}</span>
                    </div>
                    @endif
                    <form class="max-w-md mx-auto space-y-3" method="POST" action="{{ route('a.dashboard.add-student.store') }}
                    ">
                        @csrf
                        <div class="w-full">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                            <input value="{{ old('name') }}" type="text" name="name" id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Student name" required>
                            @error('name')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                            <input value="{{ old('email') }}" type="text" name="email" id="email"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Student email" required>
                            @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">password</label>
                            <input value="{{ old('password') }}" type="password" name="password" id="password"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Student password" required>
                            @error('password')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Confirm password</label>
                            <input value="{{ old('password_confirmation') }}" type="password"
                                name="password_confirmation" id="password_confirmation"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Confirm password" required>
                            @error('password_confirmation')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 ">Phone
                                number</label>
                            <input id="phone_number" type="tel" name="phone_number" value="{{ old('phone_number') }}"
                                pattern="09-[0-9]{9}"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Phone number" required>
                            @error('phone_number')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Address" required>
                            @error('address')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <input type="hidden" name="type" value="student" />
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>