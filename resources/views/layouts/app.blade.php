<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Maryam Cake & Cookies Admin') }}</title>

    <!-- Logo & Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_maryam.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #4A3728 0%, #2D2118 100%);
        }

        .nav-active {
            background: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
            border-left: 4px solid #D4AF37;
        }

        .card-premium {
            background: white;
            border: 1px solid rgba(139, 94, 60, 0.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        }
    </style>
</head>

<body class="h-full antialiased text-[#4A3728]">
    <div x-data="{ sidebarOpen: false }" class="h-screen bg-[#FDFBF7] flex overflow-hidden">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 sidebar-gradient text-white transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 shadow-2xl md:relative"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="h-full flex flex-col">
                <!-- Sidebar Header -->
                <div class="h-20 flex items-center px-6 border-b border-white/10 gap-3">
                    <img src="{{ asset('logo_maryam.png') }}" alt="Logo" class="w-10 h-10 brightness-110">
                    <span class="text-xl font-serif font-bold tracking-tighter">
                        Maryam <span class="text-[#D4AF37]">Admin</span>
                    </span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-bold">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5" />
                        </svg>
                        <span class="font-bold">Products</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span class="font-bold">Categories</span>
                    </a>

                    <a href="{{ route('admin.vouchers.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.vouchers.*') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <span class="font-bold">Vouchers</span>
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.payments.*') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="font-bold">Payments</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.orders.*') ? 'nav-active' : 'hover:bg-white/5 text-white/70' }}">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="font-bold">Orders</span>
                        @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                        @if ($pendingCount > 0)
                            <span
                                class="ml-auto bg-[#D4AF37] text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <div class="pt-8 pb-2 px-4 text-xs font-bold text-white/30 uppercase tracking-widest">Settings</div>

                    <a href="/" target="_blank"
                        class="flex items-center px-4 py-3 rounded-xl hover:bg-white/5 text-white/70 transition-all">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="font-bold">View Site</span>
                    </a>
                </nav>

                <!-- User Section -->
                <div class="p-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-3 rounded-xl bg-white/5 hover:bg-red-500/20 text-white/70 hover:text-red-400 transition-all">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-bold">Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-[#8B5E3C]/10 flex items-center justify-between px-8">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 text-[#8B5E3C]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-xl font-bold text-[#4A3728]">@yield('header_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-[#4A3728]">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-[#8B5E3C]/60 italic">Administrator</p>
                    </div>
                    <div
                        class="h-10 w-10 rounded-full gold-gradient shadow-md border-2 border-white flex items-center justify-center text-white font-black">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-[#FDFBF7] p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash Messages
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    confirmButtonColor: '#D4AF37',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: @json(session('error')),
                    confirmButtonColor: '#d33',
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: @json(session('warning')),
                    confirmButtonColor: '#D4AF37',
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: @json(session('info')),
                    confirmButtonColor: '#D4AF37',
                });
            @endif

            // Validation Errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Whoops! Something went wrong.',
                    html: `
                        <div class="text-left text-sm">
                            @foreach ($errors->all() as $error)
                                <p class="mb-1">• {{ $error }}</p>
                            @endforeach
                        </div>
                    `,
                    confirmButtonColor: '#d33',
                });
            @endif
        });

        // Global Delete Confirmation
        window.confirmDelete = function(e, message) {
            e.preventDefault();
            let form = e.target.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: message || "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D4AF37',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        };
    </script>
</body>

</html>
