<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="py-4">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                @if (session('success'))
                <div class="max-w-md p-4 mx-auto mb-4 text-sm text-center text-green-800 rounded-lg bg-green-50"
                    role="alert">
                    <span class="font-medium text-center">{{ session('success') }}</span>
                </div>
                @endif
                <div
                    class="flex flex-wrap items-center justify-between py-4 space-y-4 bg-white flex-column md:flex-row md:space-y-0 ">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative pr-3 ml-4">
                        <div
                            class="absolute inset-y-0 flex items-center pointer-events-none rtl:inset-r-0 start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <form>
                            <input name="search" type="text" id="table-search-users"
                                class="block pt-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                                placeholder="Search for report">
                        </form>
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right ">
                    <thead class="text-sm font-bold uppercase bg-gray-50 ">
                        <tr>
                            @foreach ($columns as $col)
                            <th scope="col" class="px-6 py-3">
                                {{ $col }}
                            </th>
                            @endforeach
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-base">
                                {{ $report->id }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->name }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->description }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->mark }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->status }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->student->user->name }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->subject->name }}
                            </td>
                            <td class="px-6 py-4 text-base">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td class="flex items-center gap-2 px-6 py-4 text-base">
                                <!-- Modal toggle -->
                                <a href="#" type="button" data-modal-target="editUserModal"
                                    data-modal-show="editUserModal"
                                    class="font-medium text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('a.dashboard.manage-report.delete', ['reportId' => $report->id]) }}
                                                                    " method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="font-medium text-rose-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Edit user modal -->
                <div id="editUserModal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full h-full p-4 overflow-x-hidden overflow-y-auto bg-black/40">
                    <div class="relative w-full max-w-2xl max-h-full mx-auto">
                        <!-- Modal content -->
                        <form id="editForm" class="relative bg-white rounded-lg shadow " method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t ">
                                <h3 class="text-xl font-semibold text-gray-900 ">
                                    Edit report
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
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                    <input value="{{ old('name') }}" type="text" name="name" id="name"
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
                                        id="description"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                        placeholder="Description" required>
                                    @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label for="mark" class="block mb-2 text-sm font-medium text-gray-900 ">Mark</label>
                                    <input value="{{ old('mark') }}" type="text" name="mark" id="mark"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                        placeholder="Mark" required>
                                    @error('mark')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-full">
                                    <label for="status"
                                        class="block mb-2 text-sm font-medium text-gray-900">Status</label>

                                    <select id="status" name="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                        <option {{ old('status')=='Distinction' ? 'selected' : '' }}
                                            value="Distinction">
                                            Distinction</option>
                                        <option {{ old('status')=='Pass' ? 'selected' : '' }} value="Pass">
                                            Pass</option>
                                        <option {{ old('status')=='Fail' ? 'selected' : '' }} value="Fail">
                                            Fail</option>
                                    </select>
                                    @error('status')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="hidden" name="reportId" id="reportId">
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
                        const $tr = $(this).closest('tr');
                        // Get user data from the <tr> element
                        const id = $tr.find('td:eq(0)').text().trim();
                        const name = $tr.find('td:eq(1)').text().trim();
                        const description = $tr.find('td:eq(2)').text().trim();
                        const mark = $tr.find('td:eq(3)').text().trim();
                        const status = $tr.find('td:eq(4)').text().trim();

                        // Set values in the modal form
                        $('#name').val(name);
                        $('#description').val(description);
                        $('#mark').val(mark);
                        $('#status').val(status);
                        $('#reportId').val(id);

                        // Display the modal
                        $('#editUserModal').show();
                    });

                    // Handle form submission
                    $('#editUserModal form').submit(function(e) {
                        const id = $('#reportId').val();;

                        e.currentTarget.action = `http://127.0.0.1:8000/a/dashboard/reports/update-report/${id}`
                    });

                    // Handle click event for closing the modal
                    $('[data-modal-hide="editUserModal"]').click(function() {
                        $('#editUserModal').hide();
                    });
                });
    </script>
    @endpush
</x-admin-layout>