@php
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the leading slash if present
$url_path = ltrim($url_path, '/');

// Split the path into an array
$path_array = explode('/', $url_path);

@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white">
        <a href="{{ route('a.dashboard') }}" class="flex items-center ps-2.5 mb-5">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap ">ConnectIT</span>
        </a>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('a.dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-200 group {{ in_array('dashboard', $path_array) && count(array_intersect(['students', 'courses', 'sections'], $path_array)) === 0 ? 'bg-gray-200' : '' }}">
                    <i class="text-xl fa-solid fa-chart-pie"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 {{ array_search('courses',$path_array) ? 'bg-gray-200' : '' }}"
                    aria-controls="course-dropdown" data-collapse-toggle="course-dropdown">
                    <i class="fa-solid fa-book"></i>
                    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Courses</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="course-dropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('a.dashboard.manage-course') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('manage-course',$path_array) ? "
                            bg-gray-200" : "" }}">Manage courses</a>
                    </li>
                    <li>
                        <a href="{{ route('a.dashboard.add-course') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('add-course',$path_array) ? "
                            bg-gray-200" : "" }}">Add new course</a>
                    </li>
                </ul>
            </li>

            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 {{ array_search('sections',$path_array) ? 'bg-gray-200' : '' }}"
                    aria-controls="section-dropdown" data-collapse-toggle="section-dropdown">
                    <i class="fa-solid fa-book"></i>
                    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Section</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="section-dropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('a.dashboard.manage-section') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('manage-section',$path_array) ? "
                            bg-gray-200" : "" }}">Manage sections</a>
                    </li>
                    <li>
                        <a href="{{ route('a.dashboard.add-section') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('add-section',$path_array) ? "
                            bg-gray-200" : "" }}">Add new section</a>
                    </li>
                </ul>
            </li>

            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 {{ array_search('students',$path_array) ? 'bg-gray-200' : '' }}"
                    aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <i class="fa-solid fa-users"></i>
                    <span class="flex-1 text-left ms-3 rtl:text-right whitespace-nowrap">Students</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="dropdown-example" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('a.dashboard.manage-student') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('manage-student',$path_array) ? "
                            bg-gray-200" : "" }}">Manage students</a>
                    </li>
                    <li>
                        <a href="{{ route('a.dashboard.add-student') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 {{array_search('add-student',$path_array) ? "
                            bg-gray-200" : "" }}">Add
                            new student</a>
                    </li>
                </ul>
            </li>

        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 ">
            <li>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-200  group {{ $path_array[0] === 'profile' ? 'bg-gray-200' : '' }}">
                    <i class="text-xl fa-solid fa-user"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">{{ Auth::user()->name }}</span>
                </a>
            </li>
            <li>
                <form class="flex items-center gap-2 p-2 rounded-lg text-rose-500 hover:bg-gray-200 group" method="POST"
                    action="{{ route('logout') }}">
                    @csrf
                    <i class="text-xl fa-solid fa-right-from-bracket"></i>
                    <button type="submit">Logout</button>
                </form>

            </li>
        </ul>
    </div>
</aside>