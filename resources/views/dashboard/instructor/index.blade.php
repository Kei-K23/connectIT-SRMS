<x-instructor-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="mx-auto space-y-4 shadow-md sm:rounded-lg">
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
                    @if (session('success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if (session('error'))
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
                <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm sm:rounded-lg">
                    <h2 class="text-xl font-bold">
                        Materials for {{ $user->instructor->section->name }}
                    </h2>
                    @if (session('update-success'))
                    <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                        role="alert">
                        <span class="font-medium text-center">{{ session('update-success') }}</span>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 gap-8 mt-3 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($materials as $material)
                        <div class="p-4 bg-gray-100 rounded-lg">
                            @if (Str::endsWith($material->file, ['.jpg', '.jpeg', '.png', '.gif', '.bmp']))
                            <img class="w-full h-[120px] md:h-[150px]" src="{{ asset('storage/' . $material->file) }}"
                                alt="{{ $material->name }}">
                            @elseif (Str::endsWith($material->file, ['.pdf']))
                            <div class="flex items-center justify-center w-full h-[120px] md:h-[150px] bg-gray-200">
                                <i class="text-[50px] fa-solid fa-file-pdf"></i>
                            </div>
                            @elseif (Str::endsWith($material->file, ['.zip']))
                            <div class="flex items-center justify-center w-full h-[120px] md:h-[150px] bg-gray-200">
                                <i class="text-[50px] fa-solid fa-file-zipper"></i>
                            </div>
                            @elseif (Str::endsWith($material->file, ['.docx', '.dotx']))
                            <div class="flex items-center justify-center w-full h-[120px] md:h-[150px] bg-gray-200">
                                <i class="text-[50px] fa-solid fa-file-word"></i>
                            </div>
                            @else
                            <div class="flex items-center justify-center w-full h-[120px] md:h-[150px] bg-gray-200">
                                <i class="text-[50px] fa-solid fa-file"></i>
                            </div>
                            @endif
                            <h3 class="mt-3 text-lg font-bold" id="materialName-{{$material->id}}">
                                {{ $material->name }}
                            </h3>
                            <p id="materialDescription-{{$material->id}}">
                                {{ $material->description ?? '---' }}
                            </p>
                            <p class="mt-2">
                                Uploaded {{ $material->created_at->diffForHumans() }}
                            </p>
                            <p>
                                Uploaded by {{ $material->instructor->user->name }}
                            </p>
                            <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal"
                                id="{{ $material->id }}" class="mt-3 font-medium text-blue-600 hover:underline">Edit</a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Edit user modal -->
                    <div id="editUserModal" tabindex="-1" aria-hidden="true"
                        class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full h-full p-4 overflow-x-hidden overflow-y-auto bg-black/40">
                        <div class="relative w-full max-w-2xl max-h-full mx-auto">
                            <!-- Modal content -->
                            <div class="absolute z-20 right-14 top-3">
                                <form action="{{route('materials.delete')}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="material_id" class="materialId">
                                    <button type="submit"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <form id="editForm" class="relative bg-white rounded-lg shadow" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Modal header -->
                                <div class="flex items-start justify-between p-4 border-b rounded-t ">
                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                        Edit Material
                                    </h3>
                                    <button type="button"
                                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:text-white"
                                        data-modal-hide="editUserModal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <div class="w-full">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                        <input value="{{ old('name') }}" type="text" name="name" id="myName"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                            placeholder="Name" required>
                                        @error('name')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="description"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">Description</label>
                                        <input value="{{ old('description') }}" type="text" name="description"
                                            id="myDescription"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                            placeholder="Description" required>
                                        @error('description')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="w-full">
                                        <label for="file"
                                            class="block mb-2 text-sm font-medium text-gray-900 ">File</label>
                                        <input value="{{ old('file') }}" type="file" name="file" id="file"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                            placeholder="file" required>
                                        @error('file')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                </div>
                                <input type="hidden" name="material_id" class="materialId">
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b rtl:space-x-reverse ">
                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Save
                                        all</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
            $(document).ready(function() {
                    // Handle click event for "Edit user" link
                    $('a[data-modal-show="editUserModal"]').click(function(e) {
                        e.preventDefault(); // Prevent default link behavior
                        // Get the parent <tr> element
                            const id =  e.target.id
                            const name = $(`#materialName-${id}`).text()
                            const description = $(`#materialDescription-${id}`).text()

                        // Set values in the modal form
                        $('#myName').val(name.trim());
                        $('#myDescription').val(description.trim());
                        $('.materialId').val(id);

                        // Display the modal
                        $('#editUserModal').show();
                    });

                    // Handle form submission
                    $('#editUserModal #editForm').submit(function(e) {
                        const materialId = $('.materialId').val();
                        e.currentTarget.action =
                            `http://127.0.0.1:8000/materials/${materialId}/update`
                    });

                    // Handle click event for closing the modal
                    $('[data-modal-hide="editUserModal"]').click(function() {
                        $('#editUserModal').hide();
                    });
                });
        </script>
        @endpush
</x-instructor-layout>