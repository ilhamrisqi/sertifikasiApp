<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventori Medis' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="flex items-center">
            <button id="menu-toggle" class="text-gray-600 mr-3 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="text-xl font-bold text-blue-600">Inventori Medis</h1>
        </div>
        <div class="flex items-center gap-2 sm:gap-4">
            <span class="text-xs sm:text-sm text-gray-600">Login sebagai: <strong>{{ auth()->user()->role ?? 'Tamu' }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-2 py-1 sm:px-3 sm:py-1 text-xs sm:text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="flex flex-col md:flex-row">
        <!-- Sidebar - hidden on mobile by default -->
        <aside id="sidebar" class="bg-white w-full md:w-64 shadow-md p-4 hidden md:block fixed md:sticky md:top-0 md:h-screen z-10">
            <ul class="space-y-2 text-sm text-gray-700">
                <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('dashboard') ? 'bg-blue-100 font-medium' : '' }}">Dashboard</a></li>
                
                @if(auth()->user()->role == 'Admin' || auth()->user()->role == 'Pharmacist')
                <li><a href="{{ route('medicines.index') }}" class="block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('medicines.*') ? 'bg-blue-100 font-medium' : '' }}">Obat</a></li>
                @endif
                
                @if(auth()->user()->role == 'Admin' || auth()->user()->role == 'Technician')
                <li><a href="{{ route('medical.index') }}" class="block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('medical.*') ? 'bg-blue-100 font-medium' : '' }}">Peralatan Medis</a></li>
                @endif
                
                @if(auth()->user()->role == 'Admin')
                <li><a href="{{ route('users.index') }}" class="block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('users.*') ? 'bg-blue-100 font-medium' : '' }}">Pengguna</a></li>
                <li><a href="{{ route('consumables.index') }}" class="block px-4 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('consumables.*') ? 'bg-blue-100 font-medium' : '' }}">Consumable</a></li>
                @endif
            </ul>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-4 sm:p-6 md:ml-0">
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
            @endif
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <!-- JavaScript untuk toggle sidebar di mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
            });
            
            // Hide sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isMobile = window.innerWidth < 768;
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnMenuToggle = menuToggle.contains(event.target);
                
                if (isMobile && !isClickInsideSidebar && !isClickOnMenuToggle && !sidebar.classList.contains('hidden')) {
                    sidebar.classList.add('hidden');
                }
            });
            
            // Adjust sidebar visibility on resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('hidden');
                } else {
                    sidebar.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>