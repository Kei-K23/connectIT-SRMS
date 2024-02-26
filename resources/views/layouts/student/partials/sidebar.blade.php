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
        <a href="{{ route('s.dashboard') }}" class="flex items-center ps-2.5 mb-5">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap ">ConnectIT</span>
        </a>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('s.dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-200 group {{ in_array('dashboard', $path_array) && count(array_intersect(['attendance', 'report'], $path_array)) === 0 ? 'bg-gray-200' : '' }}">
                    <i class="text-xl fa-solid fa-chart-pie"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('s.dashboard.attendance') }}"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg  group hover:bg-gray-200 {{array_search('attendance',$path_array) ? "
                    bg-gray-200" : "" }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="ms-3">
                        Attendance
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('s.dashboard.report') }}"
                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg  group hover:bg-gray-200 {{array_search('report',$path_array) ? "
                    bg-gray-200" : "" }}">
                    <i class="fa-solid fa-magnifying-glass-chart"></i>
                    <span class="ms-3">
                        Reports
                    </span>
                </a>
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
