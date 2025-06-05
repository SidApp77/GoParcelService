{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-green-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold">Admin Panel</span>
                </div>
                <div class="flex items-center">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoParcel - @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200">
                <div class="flex items-center justify-center h-16 px-4 bg-primary-700">
                    <span class="text-white text-xl font-bold">GoParcel</span>
                </div>

                <!-- Sidebar -->
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto bg-white w-64 border-r border-gray-200">
                    <nav id="sidebarMenu" class="flex-1 space-y-2">

                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.dashboard') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>

                        <!-- Staff -->
                        <a href="{{ route('admin.staff.list') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.staff.list') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-users-cog mr-3"></i>
                            Staff
                        </a>

                        <!-- Customer -->
                        <a href="{{ route('admin.customer.list') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.customer.list') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-users mr-3"></i>
                            Customer
                        </a>

                        <!-- Route -->
                        <a href="{{ route('admin.route.list') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.route.list') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-route mr-3"></i>
                            Route
                        </a>

                        <!-- Vehicle -->
                        <a href="{{ route('admin.vehicle.list') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.vehicle.list') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-truck mr-3"></i>
                            Vehicle
                        </a>

                        <!-- Courier Dropdown -->
                        <div x-data="{ open: {{ request()->routeIs('admin.courier.category') || request()->routeIs('admin.courier.charges') ? 'true' : 'false' }} }" class="relative">
                            <!-- Main Toggle Button -->
                            <button @click="open = !open"
                                class="flex items-center w-full px-4 py-2 text-sm font-semibold rounded-lg transition duration-200
                                    {{ request()->routeIs('admin.courier.*') ? 'bg-green-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                                <i class="fas fa-shipping-fast mr-3 text-lg"></i>
                                <span class="flex-grow text-left">Courier</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </button>

                            <!-- Dropdown Items -->
                            <div x-show="open" x-transition x-cloak class="ml-6 mt-2 space-y-2 pl-2 border-l-2 border-green-300">
                                <a href="{{ route('admin.courier.category') }}"
                                    class="flex items-center px-3 py-2 text-sm rounded-md transition duration-150
                                        {{ request()->routeIs('admin.courier.category') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-green-600' }}">
                                    <i class="fas fa-tags mr-2 w-4 text-sm"></i>
                                    Courier Category
                                </a>

                                <a href="{{ route('admin.courier.charges') }}"
                                    class="flex items-center px-3 py-2 text-sm rounded-md transition duration-150
                                        {{ request()->routeIs('admin.courier.charges') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-green-600' }}">
                                    <i class="fas fa-rupee-sign mr-2 w-4 text-sm"></i>
                                    Courier Charges
                                </a>
                            </div>
                        </div>

                        <!-- Ensure Alpine.js is loaded (place at bottom of layout once) -->
                        <script src="//unpkg.com/alpinejs" defer></script>


                        <!-- Book Courier -->
                        <a href="{{ route('admin.book.courier') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.book.courier') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-calendar-check mr-3"></i>
                            Book Courier
                        </a>

                        <!-- Payment -->
                        <a href="{{ route('admin.payment.list') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.payment.list') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-credit-card mr-3"></i>
                            Payment
                        </a>

                        <!-- Monthly Report -->
                        <a href="{{ route('admin.report.monthly') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.report.monthly') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-file-invoice-dollar mr-3"></i>
                            Monthly Report
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('admin.settings') ? 'bg-primary-700 text-white shadow-md hover:bg-primary-600' : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900' }}">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>

                    </nav>
                </div>

                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full" src="{{ asset('images/profile-img-1.jpg') }}"
                            alt="User avatar">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navbar -->
            <header class="flex min-h-16 items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="ml-4 text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>

                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                        <i class="fas fa-envelope"></i>
                    </button>
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                            <img class="w-9 h-9 rounded-full" src="{{ asset('images/profile-img-1.jpg') }}"
                                alt="User avatar">
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Profile -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            @yield('main')
            @yield('script')
            <link href="{{ asset('css/style.css') }}" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div class="fixed inset-0 z-40 md:hidden hidden" id="mobileSidebar">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
        <div class="relative flex flex-col w-72 max-w-xs h-full bg-white">
            <div class="flex items-center justify-center h-16 px-4 bg-primary-700">
                <span class="text-white text-xl font-bold">SWIFTCART</span>
                <button class="absolute right-4 text-white" id="closeSidebar">

                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                <nav class="flex-1 space-y-2">
                    <!-- Same navigation links as desktop sidebar -->
                    <a href="#"
                        class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-md bg-primary-600 group">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <!-- Other menu items... -->
                </nav>
            </div>
        </div>
    </div>

    <script>
        // Show sidebar option in Page title
        document.addEventListener('DOMContentLoaded', function () {
            const pageTitle = document.getElementById('pageTitle');
            const navLinks = document.querySelectorAll('nav a[data-title]');

            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const newTitle = this.getAttribute('data-title');
                    pageTitle.textContent = newTitle;
                });
            });
        });

        // Highlight active sidebar item
        const currentURL = window.location.pathname.split("/").pop();
        const links = document.querySelectorAll('#sidebarMenu a');

        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentURL || (href === "dashboard.html" && currentURL === "")) {
                link.classList.add('bg-primary-600', 'text-white');
                link.classList.remove('text-gray-600');
            }
        });

        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar Title Change
            const pageTitle = document.getElementById('pageTitle');
            const navLinks = document.querySelectorAll('nav a[data-title]');
            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const newTitle = this.getAttribute('data-title');
                    pageTitle.textContent = newTitle;
                });
            });

            // Mobile Sidebar Toggle
            const mobileSidebar = document.getElementById('mobileSidebar');
            const openButtons = document.querySelectorAll('[data-toggle="sidebar"]');
            const closeButton = document.getElementById('closeSidebar');
            openButtons.forEach(button => {
                button.addEventListener('click', () => {
                    mobileSidebar.classList.remove('hidden');
                });
            });
            closeButton.addEventListener('click', () => {
                mobileSidebar.classList.add('hidden');
            });

            // User Menu Dropdown
            const userMenuButton = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');
            userMenuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', function () {
                userMenu.classList.add('hidden');
            });
            userMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });


        // ================ Image previiew and delete ========================
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const oldInput = document.getElementById('image');
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');

            // Create a fresh clone and bind change event
            const newInput = oldInput.cloneNode();
            newInput.addEventListener('change', previewImage);
            newInput.className = oldInput.className;
            newInput.id = 'image';
            newInput.name = 'image';

            // Replace old input with new input
            oldInput.parentNode.replaceChild(newInput, oldInput);

            // Reset UI
            preview.src = '#';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        }


        function generateSlug(value) {
            let slug = value.toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')

</body>

</html>