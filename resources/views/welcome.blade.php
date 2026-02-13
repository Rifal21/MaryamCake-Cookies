<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maryam Cake & Cookies - Premium Handmade Treats</title>

    <!-- Logo & Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_maryam.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FDFBF7;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-nav {
            background: rgba(253, 251, 247, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(139, 94, 60, 0.1);
        }

        .gold-pill {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        }

        .cake-card:hover .cake-image {
            transform: scale(1.05);
        }

        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body x-data="cartApp()" x-init="init()" class="antialiased text-[#4A3728]">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="flex items-center gap-3">
                        <img src="{{ asset('logo_maryam.png') }}" alt="Maryam Cake Logo" class="w-12 h-12">
                        <span class="text-xl md:text-2xl font-serif font-bold tracking-tighter text-[#8B5E3C]">
                            Maryam <span class="text-[#D4AF37]">Cake & Cookies</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 lg:space-x-8 items-center">
                    <a href="#home" class="hover:text-[#D4AF37] transition-colors font-medium">{{ __('Home') }}</a>
                    <a href="#products"
                        class="hover:text-[#D4AF37] transition-colors font-medium">{{ __('Products') }}</a>
                    <a href="#about"
                        class="hover:text-[#D4AF37] transition-colors font-medium">{{ __('Our Story') }}</a>
                    <a href="#testimonials"
                        class="hover:text-[#D4AF37] transition-colors font-medium">{{ __('Testimonials') }}</a>
                    <a href="#contact"
                        class="hover:text-[#D4AF37] transition-colors font-medium">{{ __('Contact') }}</a>
                    <a href="{{ route('tracking.index') }}"
                        class="text-[#D4AF37] hover:scale-105 transition-all font-bold flex items-center gap-1 border-b-2 border-[#D4AF37]/30 pb-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {{ __('Track Order') }}
                    </a>

                    <!-- Language Switcher -->
                    <div class="flex items-center gap-1 bg-[#8B5E3C]/10 rounded-full p-1 border border-[#8B5E3C]/20">
                        <a href="{{ route('lang.switch', 'id') }}"
                            class="px-3 py-1 rounded-full text-xs font-bold transition-all {{ app()->getLocale() == 'id' ? 'bg-[#8B5E3C] text-white shadow-md' : 'text-[#8B5E3C] hover:bg-white/50' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="px-3 py-1 rounded-full text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-[#8B5E3C] text-white shadow-md' : 'text-[#8B5E3C] hover:bg-white/50' }}">EN</a>
                    </div>

                    <button @click="showCart = true"
                        class="relative p-2 text-[#8B5E3C] hover:text-[#D4AF37] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span x-show="cart.length > 0" x-text="cart.length"
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#D4AF37] rounded-full"></span>
                    </button>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center gap-4">
                    <button @click="showCart = true" class="relative p-2 text-[#8B5E3C]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span x-show="cart.length > 0" x-text="cart.length"
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#D4AF37] rounded-full"></span>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-[#8B5E3C]">
                        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition
            class="md:hidden glass-nav absolute w-full pb-6 shadow-xl border-b border-[#8B5E3C]/10 backdrop-blur-xl">
            <div class="px-2 pt-2 pb-3 space-y-2 sm:px-3 text-center">
                <a @click="mobileMenuOpen = false" href="#home"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5">{{ __('Home') }}</a>
                <a @click="mobileMenuOpen = false" href="#products"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5">{{ __('Products') }}</a>
                <a @click="mobileMenuOpen = false" href="#about"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5">{{ __('Our Story') }}</a>
                <a @click="mobileMenuOpen = false" href="#testimonials"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5">{{ __('Testimonials') }}</a>
                <a @click="mobileMenuOpen = false" href="#contact"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5">{{ __('Contact') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('tracking.index') }}"
                    class="block px-3 py-3 text-lg font-medium border-b border-[#8B5E3C]/5 text-[#D4AF37] font-bold">{{ __('Track Order') }}</a>

                <!-- Mobile Language Switcher -->
                <div class="flex justify-center gap-4 pt-4 pb-2">
                    <a href="{{ route('lang.switch', 'id') }}"
                        class="px-6 py-2 rounded-full font-bold transition-all {{ app()->getLocale() == 'id' ? 'bg-[#8B5E3C] text-white shadow-md' : 'bg-[#8B5E3C]/10 text-[#8B5E3C]' }}">Indonesia</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="px-6 py-2 rounded-full font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-[#8B5E3C] text-white shadow-md' : 'bg-[#8B5E3C]/10 text-[#8B5E3C]' }}">English</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
                    <div x-show="loaded" x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0 text-center md:text-left">
                        <span
                            class="inline-block px-4 py-1.5 rounded-full bg-[#8B5E3C]/10 text-[#8B5E3C] text-sm font-semibold tracking-wide uppercase mb-6">
                            {{ __('Est. 2020 • Handmade with Love') }}
                        </span>
                        <h1 class="text-5xl md:text-7xl font-serif font-bold leading-tight mb-6">
                            {!! __('Indulge in <br><span class="text-[#D4AF37]">Premium</span> Sweets') !!}
                        </h1>
                        <p class="text-lg md:text-xl text-[#6B4F3A] leading-relaxed mb-8 max-w-xl">
                            {{ __('Each bite is a testimony of our passion for perfection. From delicate cookies to decadent custom cakes, we bring your sweet dreams to life.') }}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#products"
                                class="px-8 py-4 gold-pill text-white rounded-full font-bold text-center transition-transform hover:scale-105 shadow-lg shadow-[#D4AF37]/30">
                                {{ __('Order Now') }}
                            </a>
                            <a href="#about"
                                class="px-8 py-4 border-2 border-[#8B5E3C] text-[#8B5E3C] rounded-full font-bold text-center transition-all hover:bg-[#8B5E3C] hover:text-white">
                                {{ __('Our Story') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Hero Image -->
                <div class="relative" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 300)">
                    <div x-show="loaded" x-transition:enter="transition ease-out duration-1000 transform scale-95"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        class="relative rounded-[3rem] overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/hero.png') }}" alt="Signature Cake" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#4A3728]/40 to-transparent"></div>
                    </div>
                    <!-- Decorative element -->
                    <div
                        class="absolute -bottom-6 -left-6 md:-bottom-12 md:-left-12 w-32 h-32 md:w-48 md:h-48 border-8 border-[#D4AF37]/20 rounded-full -z-10 animate-pulse">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services/Features -->
    <section class="py-16 bg-[#F8F4ED]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="swiper featureSwiper pb-8">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="flex items-center gap-6 p-6 rounded-2xl bg-white shadow-sm h-full">
                            <div
                                class="w-16 h-16 flex-shrink-0 bg-[#D4AF37]/10 rounded-full flex items-center justify-center text-[#D4AF37]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">{{ __('Freshly Baked') }}</h3>
                                <p class="text-sm text-[#6B4F3A]">{{ __('Baked daily with the finest ingredients.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex items-center gap-6 p-6 rounded-2xl bg-white shadow-sm h-full">
                            <div
                                class="w-16 h-16 flex-shrink-0 bg-[#D4AF37]/10 rounded-full flex items-center justify-center text-[#D4AF37]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">{{ __('Custom Made') }}</h3>
                                <p class="text-sm text-[#6B4F3A]">{{ __('Tailored to your special celebrations.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="flex items-center gap-6 p-6 rounded-2xl bg-white shadow-sm h-full">
                            <div
                                class="w-16 h-16 flex-shrink-0 bg-[#D4AF37]/10 rounded-full flex items-center justify-center text-[#D4AF37]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl">{{ __('Fast Delivery') }}</h3>
                                <p class="text-sm text-[#6B4F3A]">{{ __('Same day or scheduled delivery.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add pagination dots for mobile -->
                <div class="swiper-pagination md:hidden"></div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[#D4AF37] font-bold tracking-widest uppercase text-sm">{{ __('Our Menu') }}</span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold mt-2">{{ __('Signature Flavors') }}</h2>
                <div class="w-24 h-1 bg-[#D4AF37] mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button @click="currentCategory = 'all'"
                    :class="currentCategory === 'all' ? 'bg-[#4A3728] text-white shadow-lg shadow-[#4A3728]/20' :
                        'bg-white text-[#4A3728] hover:bg-gray-100'"
                    class="px-6 py-2 rounded-full font-bold transition-all border border-[#4A3728]/10">
                    {{ __('All') }}
                </button>
                @foreach ($categories as $cat)
                    <button @click="currentCategory = '{{ $cat->id }}'"
                        :class="currentCategory === '{{ $cat->id }}' ?
                            'bg-[#4A3728] text-white shadow-lg shadow-[#4A3728]/20' :
                            'bg-white text-[#4A3728] hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-bold transition-all border border-[#4A3728]/10 uppercase text-xs tracking-widest">
                        {{ __($cat->name) }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-10">
                @foreach ($products as $product)
                    <div x-show="currentCategory === 'all' || currentCategory === '{{ $product->category_id }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        @click="openProductModal({
                            id: {{ $product->id }},
                            name: @js(__($product->name)),
                            price: {{ $product->price }},
                            description: @js(__($product->description)),
                            image: '{{ asset($product->image) }}',
                            category: @js(__($product->category->name)),
                            is_premium: {{ $product->is_premium ? 'true' : 'false' }}
                        })"
                        class="cake-card group bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-xl shadow-[#4A3728]/5 transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="relative overflow-hidden aspect-[4/3] bg-[#8B5E3C]/5 flex items-center justify-center">
                            @if ($product->image && $product->image !== 'images/products/default.jpg' && file_exists(public_path($product->image)))
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}"
                                    loading="lazy"
                                    class="cake-image w-full h-full object-cover transition-transform duration-700">
                            @else
                                <div class="flex flex-col items-center gap-3">
                                    <i
                                        class="fa-solid fa-cake-candles text-[#D4AF37] text-5xl md:text-6xl opacity-50"></i>
                                    <span
                                        class="text-[10px] text-[#8B5E3C]/30 font-black uppercase tracking-widest">{{ __('No Image') }}</span>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 md:top-4 md:right-4 flex flex-col gap-2 items-end">
                                @if ($product->is_premium)
                                    <span
                                        class="bg-[#D4AF37] text-white px-2 py-1 md:px-4 md:py-1.5 rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-widest shadow-lg shadow-[#D4AF37]/30">
                                        {{ __('Premium') }}
                                    </span>
                                @endif
                                <span
                                    class="bg-white/90 backdrop-blur px-2 py-1 md:px-4 md:py-1.5 rounded-full text-[10px] md:text-xs font-bold text-[#8B5E3C] shadow-sm">
                                    {{ __($product->category->name) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 md:p-8">
                            <div class="flex justify-between items-start mb-2 md:mb-4">
                                <h3 class="text-lg md:text-2xl font-bold line-clamp-1">{{ __($product['name']) }}</h3>
                            </div>
                            <p
                                class="text-[#6B4F3A] text-[10px] md:text-sm leading-relaxed mb-4 md:mb-6 line-clamp-2 md:line-clamp-none">
                                {{ __($product['description']) }}
                            </p>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <span class="text-lg md:text-2xl font-bold text-[#8B5E3C]">
                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                </span>
                                <button
                                    @click.stop="addToCart({
                                        id: {{ $product['id'] }},
                                        name: '{{ $product['name'] }}',
                                        price: {{ $product['price'] }},
                                        image: '{{ asset($product['image']) }}'
                                    })"
                                    class="p-2 md:p-3 bg-[#4A3728] text-white rounded-xl md:rounded-2xl hover:bg-[#D4AF37] transition-all-300 transform group-hover:rotate-6 shadow-md shadow-[#4A3728]/20 hover:shadow-[#D4AF37]/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-[#4A3728] text-white relative overflow-hidden">
        <!-- SVG background pattern -->
        <div class="absolute inset-0 opacity-5 pointer-events-none overflow-hidden">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <pattern id="pattern-cake" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                    <circle cx="5" cy="5" r="1" fill="white" />
                </pattern>
                <rect width="100" height="100" fill="url(#pattern-cake)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="order-2 md:order-1">
                    <div class="relative">
                        <img src="{{ asset('images/custom-cake.png') }}" alt="Our Kitchen"
                            class="rounded-[3rem] shadow-2xl relative z-20">
                        <div
                            class="absolute -top-10 -right-10 w-40 h-40 border-[12px] border-[#D4AF37] rounded-full z-10 hidden md:block">
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2 space-y-8">
                    <span
                        class="text-[#D4AF37] font-bold tracking-widest uppercase text-sm">{{ __('The Maryam Kitchen') }}</span>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold">{!! __('Every Treat is a <br>Story of Love') !!}</h2>
                    <p class="text-lg text-white/80 leading-relaxed">
                        {{ __("Started in a small home kitchen with a single oven and a massive passion, Maryam Cake and Cookies has grown into a sanctuary for dessert lovers. We believe that cakes shouldn't just look spectacular; they must taste unforgettable.") }}
                    </p>
                    <p class="text-lg text-white/80 leading-relaxed">
                        {{ __('We use only premium ingredients—imported chocolates, pure butter, and fresh seasonal fruits. No preservatives, no shortcuts, just pure culinary art.') }}
                    </p>
                    <div class="grid grid-cols-2 gap-8 pt-6">
                        <div>
                            <span class="block text-4xl font-serif font-bold text-[#D4AF37]">1,000+</span>
                            <span class="text-sm text-white/60">{{ __('Cakes Baked') }}</span>
                        </div>
                        <div>
                            <span class="block text-4xl font-serif font-bold text-[#D4AF37]">500+</span>
                            <span class="text-sm text-white/60">{{ __('Happy Clients') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-[#FDFBF7]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span
                    class="text-[#D4AF37] font-bold tracking-widest uppercase text-sm">{{ __('Testimonials') }}</span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold mt-2 text-[#4A3728]">
                    {{ __('What Our Clients Say') }}</h2>
                <div class="w-24 h-1 bg-[#D4AF37] mx-auto mt-6 rounded-full"></div>
            </div>

            <!-- Swiper Testimonials -->
            <div class="swiper testimonialSwiper pb-12">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide p-4 h-auto">
                        <div
                            class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-[#4A3728]/5 border border-[#8B5E3C]/5 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex text-[#D4AF37] mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[#6B4F3A] italic mb-6 leading-relaxed">
                                    "{{ __('Kuenya lembut banget dan manisnya pas! Red Velvet Cookies-nya jadi favorit keluarga saya sekarang. Pengirimannya juga sangat aman dan rapi.') }}"
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full gold-pill flex items-center justify-center text-white font-bold shadow-md">
                                    S</div>
                                <div>
                                    <h4 class="font-bold text-[#4A3728]">Siti Sarah</h4>
                                    <p class="text-xs text-[#8B5E3C]/60 uppercase tracking-widest">
                                        {{ __('Pelanggan Setia') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="swiper-slide p-4 h-auto">
                        <div
                            class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-[#4A3728]/5 border border-[#8B5E3C]/5 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex text-[#D4AF37] mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[#6B4F3A] italic mb-6 leading-relaxed">
                                    "{{ __('Brownies-nya bener-bener fudgy dan walnutnya melimpah. Cocok banget buat hadiah atau hampers. Gak pernah kecewa order di Maryam Cake!') }}"
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full gold-pill flex items-center justify-center text-white font-bold shadow-md">
                                    A</div>
                                <div>
                                    <h4 class="font-bold text-[#4A3728]">Andi Pratama</h4>
                                    <p class="text-xs text-[#8B5E3C]/60 uppercase tracking-widest">
                                        {{ __('Business Owner') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="swiper-slide p-4 h-auto">
                        <div
                            class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-[#4A3728]/5 border border-[#8B5E3C]/5 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex text-[#D4AF37] mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[#6B4F3A] italic mb-6 leading-relaxed">
                                    "{{ __('Custom cake-nya bener-bener sesuai ekspektasi, bahkan lebih bagus aslinya! Rasanya enak, desainnya detail dan sangat premium kualitasnya.') }}"
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full gold-pill flex items-center justify-center text-white font-bold shadow-md">
                                    D</div>
                                <div>
                                    <h4 class="font-bold text-[#4A3728]">Dewi Lestari</h4>
                                    <p class="text-xs text-[#8B5E3C]/60 uppercase tracking-widest">
                                        {{ __('Food Blogger') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="swiper-slide p-4 h-auto">
                        <div
                            class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-[#4A3728]/5 border border-[#8B5E3C]/5 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex text-[#D4AF37] mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[#6B4F3A] italic mb-6 leading-relaxed">
                                    "{{ __('Pelayanannya ramah sekali, kuenya cantik dan rasanya juara! Recomended banget buat acara keluarga atau kantor.') }}"
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full gold-pill flex items-center justify-center text-white font-bold shadow-md">
                                    R</div>
                                <div>
                                    <h4 class="font-bold text-[#4A3728]">Rina Marlina</h4>
                                    <p class="text-xs text-[#8B5E3C]/60 uppercase tracking-widest">
                                        {{ __('Pelanggan Setia') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 5 -->
                    <div class="swiper-slide p-4 h-auto">
                        <div
                            class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-[#4A3728]/5 border border-[#8B5E3C]/5 hover:-translate-y-2 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex text-[#D4AF37] mb-4">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-[#6B4F3A] italic mb-6 leading-relaxed">
                                    "{{ __('Hampers nya mewah banget, isinya cookies yang bener-bener premium rasanya. Cocok untuk hadiah klien atau saudara.') }}"
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full gold-pill flex items-center justify-center text-white font-bold shadow-md">
                                    B</div>
                                <div>
                                    <h4 class="font-bold text-[#4A3728]">Budi Santoso</h4>
                                    <p class="text-xs text-[#8B5E3C]/60 uppercase tracking-widest">
                                        {{ __('Corporate Client') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-[#FDFBF7] pt-24 pb-12 border-t border-[#8B5E3C]/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-2">
                    <a href="#" class="flex items-center gap-4 mb-6">
                        <img src="{{ asset('logo_maryam.png') }}" alt="Maryam Cake Logo" class="w-14 h-14">
                        <span class="text-3xl font-serif font-bold text-[#8B5E3C]">
                            Maryam <span class="text-[#D4AF37]">Cake</span>
                        </span>
                    </a>
                    <p class="text-[#6B4F3A] text-lg max-w-md leading-relaxed mb-8">
                        {{ __('Bringing premium homemade sweetness to your special moments. Quality you can taste, designs you can\'t forget.') }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-12 h-12 rounded-full border border-[#8B5E3C]/20 flex items-center justify-center hover:bg-[#D4AF37] hover:text-white transition-all">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-12 h-12 rounded-full border border-[#8B5E3C]/20 flex items-center justify-center hover:bg-[#D4AF37] hover:text-white transition-all">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-[#8B5E3C] mb-6">{{ __('Quick Links') }}</h4>
                    <ul class="space-y-4">
                        <li><a href="#home" class="hover:text-[#D4AF37] transition-all">{{ __('Home') }}</a>
                        </li>
                        <li><a href="#products" class="hover:text-[#D4AF37] transition-all">{{ __('Products') }}</a>
                        </li>
                        <li><a href="#testimonials"
                                class="hover:text-[#D4AF37] transition-all">{{ __('Testimonials') }}</a></li>
                        <li><a href="#contact" class="hover:text-[#D4AF37] transition-all">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-[#8B5E3C] mb-6">{{ __('Contact Info') }}</h4>
                    <ul class="space-y-4 text-[#6B4F3A]">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 text-[#D4AF37]"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Kp. Baru, RT.04/RW.05, Desa Ciawi, Kec. Ciawi, Kab. Tasikmalaya</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#D4AF37]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+62 857 9237 3482</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-[#8B5E3C]/10 pt-8 flex flex-col md:row justify-between items-center gap-4">
                <p class="text-sm text-[#6B4F3A]/60 font-medium">© 2025 Maryam Cake and Cookies.
                    {{ __('All rights reserved.') }}
                </p>
                <div class="flex gap-6 text-sm text-[#6B4F3A]/60">
                    <a href="#" class="hover:text-[#8B5E3C]">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-[#8B5E3C]">{{ __('Terms of Service') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Sidebar/Modal -->
    <div x-show="showCart" x-cloak class="fixed inset-0 z-[100] overflow-hidden" aria-labelledby="slide-over-title"
        role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-[#4A3728]/60 backdrop-blur-sm transition-opacity" @click="showCart = false">
        </div>

        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <div x-show="showCart" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md">
                <div class="h-full flex flex-col bg-white shadow-2xl overflow-y-scroll">
                    <div class="flex-1 py-10 overflow-y-auto px-6 sm:px-10">
                        <div class="flex items-start justify-between">
                            <h2 class="text-3xl font-serif font-bold text-[#8B5E3C]" id="slide-over-title">
                                {{ __('My Cart') }}</h2>
                            <div class="ml-3 h-7 flex items-center">
                                <button type="button" class="text-[#8B5E3C] hover:text-[#D4AF37]"
                                    @click="showCart = false">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-12">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 divide-y divide-[#8B5E3C]/10">
                                    <template x-if="cart.length === 0">
                                        <div class="py-20 text-center">
                                            <div
                                                class="w-24 h-24 bg-[#F8F4ED] rounded-full flex items-center justify-center mx-auto mb-6">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-10 w-10 text-[#8B5E3C]/30" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <p class="text-xl text-[#6B4F3A] font-medium">
                                                {{ __('Your cart is empty.') }}</p>
                                            <a href="#products" @click="showCart = false"
                                                class="mt-4 inline-block text-[#D4AF37] font-bold underline">{{ __('Discover our treats') }}</a>
                                        </div>
                                    </template>

                                    <template x-for="item in cart" :key="item.id">
                                        <li class="py-8 flex">
                                            <div
                                                class="flex-shrink-0 w-24 h-24 rounded-2xl overflow-hidden border border-[#8B5E3C]/10 shadow-sm flex items-center justify-center bg-[#8B5E3C]/5">
                                                <template x-if="!isDefaultImage(item.image)">
                                                    <img :src="item.image" :alt="item.name" loading="lazy"
                                                        class="w-full h-full object-center object-cover">
                                                </template>
                                                <template x-if="isDefaultImage(item.image)">
                                                    <i class="fa-solid fa-cookie-bite text-[#D4AF37] text-3xl"></i>
                                                </template>
                                            </div>

                                            <div class="ml-6 flex-1 flex flex-col">
                                                <div>
                                                    <div class="flex justify-between text-lg font-bold">
                                                        <h3 x-text="item.name" class="text-[#4A3728]"></h3>
                                                        <p class="ml-4 text-[#8B5E3C]"
                                                            x-text="formatPrice(item.price * item.quantity)"></p>
                                                    </div>
                                                </div>
                                                <div class="flex-1 flex items-end justify-between text-sm">
                                                    <div
                                                        class="flex items-center gap-4 bg-[#F8F4ED] px-4 py-2 rounded-xl">
                                                        <button @click="updateQty(item.id, -1)"
                                                            class="text-[#8B5E3C] font-black text-lg">-</button>
                                                        <span x-text="item.quantity"
                                                            class="font-bold text-[#4A3728] w-6 text-center"></span>
                                                        <button @click="updateQty(item.id, 1)"
                                                            class="text-[#8B5E3C] font-black text-lg">+</button>
                                                    </div>

                                                    <div class="flex">
                                                        <button @click="removeFromCart(item.id)" type="button"
                                                            class="font-bold text-[#D4AF37] hover:text-[#B8860B]">{{ __('Remove') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <!-- Voucher Section -->
                            <div class="mt-10 py-6 border-t border-b border-[#8B5E3C]/5" x-show="cart.length > 0">
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-3">
                                    {{ __('Apply Voucher') }}
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="voucherCode" :disabled="appliedVoucher"
                                        class="flex-1 rounded-xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-4 py-2 uppercase tracking-widest text-sm font-bold placeholder:normal-case placeholder:font-normal"
                                        placeholder="{{ __('Enter voucher code') }}">
                                    <button @click="applyVoucher()" :disabled="!voucherCode || appliedVoucher"
                                        class="px-6 py-2 gold-pill text-white rounded-xl font-bold text-sm disabled:opacity-50 disabled:grayscale transition-all">
                                        <span x-show="!appliedVoucher">{{ __('Apply') }}</span>
                                        <svg x-show="appliedVoucher" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </div>
                                <template x-if="appliedVoucher">
                                    <div class="mt-3 flex justify-between items-center text-green-600">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7a1 1 0 011.414-1.414L10 15.586l6.293-6.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ __('Voucher Applied') }}: <span x-text="appliedVoucher"></span>
                                        </span>
                                        <button @click="removeVoucher()"
                                            class="text-[10px] font-black uppercase tracking-widest text-red-500 hover:underline">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <!-- Payment Method Section -->
                            <div class="mt-6 py-6 border-b border-[#8B5E3C]/5" x-show="cart.length > 0">
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-3">
                                    {{ __('Payment Method') }}
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <template x-for="method in paymentMethods" :key="method.id">
                                        <button @click="selectedPayment = method.name"
                                            class="flex flex-col items-center justify-center p-3 rounded-2xl border-2 transition-all group"
                                            :class="selectedPayment === method.name ?
                                                'border-[#D4AF37] bg-[#D4AF37]/5 shadow-sm' :
                                                'border-[#8B5E3C]/10 hover:border-[#D4AF37]/30 bg-white'">
                                            <span class="text-sm font-black uppercase tracking-widest text-[#4A3728]"
                                                x-text="method.name"></span>
                                            <span class="text-[10px] font-bold text-[#8B5E3C]/60 mt-1"
                                                x-text="method.name === 'COD' ? 'Bayar di Tempat' : 'Transfer'"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-[#8B5E3C]/10 py-10 px-8 sm:px-10 bg-[#FDFBF7]"
                            x-show="cart.length > 0">
                            <!-- Pricing Summary -->
                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm font-bold text-[#6B4F3A]/60">
                                    <p>{{ __('Subtotal') }}</p>
                                    <p x-text="formatPrice(subtotal)"></p>
                                </div>
                                <p x-text="'- ' + formatPrice(discount)"></p>
                            </div>
                            <div x-show="adminFee > 0" class="flex justify-between text-sm font-bold text-[#8B5E3C]">
                                <p>{{ __('Admin Fee') }}</p>
                                <p x-text="'+ ' + formatPrice(adminFee)"></p>
                            </div>
                            <div x-show="shippingCost > 0"
                                class="flex justify-between text-sm font-bold text-[#8B5E3C]">
                                <p>{{ __('Shipping Fee') }}</p>
                                <p x-text="'+ ' + formatPrice(shippingCost)"></p>
                            </div>
                            <div
                                class="flex justify-between text-2xl font-bold text-[#4A3728] pt-4 border-t border-[#8B5E3C]/5">
                                <p>{{ __('Total') }}</p>
                                <p x-text="formatPrice(totalPrice)"></p>
                            </div>
                        </div>

                        <p class="mt-0.5 text-sm text-[#6B4F3A] mb-8 italic text-center" x-show="shippingCost > 0">
                            {{ __('Flat rate shipping fee applied.') }}
                        </p>
                        <p class="mt-0.5 text-sm text-[#6B4F3A] mb-8 italic text-center" x-show="shippingCost == 0">
                            {{ __('Free shipping applied.') }}
                        </p>
                        <div class="mt-6">
                            <button @click="checkout()"
                                class="w-full flex justify-center items-center px-6 py-4 rounded-full shadow-lg gold-pill text-xl font-bold text-white transition-transform hover:scale-[1.02]">
                                {{ __('Confirm Order Details') }}
                            </button>
                        </div>
                        <div class="mt-6 flex justify-center text-sm text-center text-[#6B4F3A]">
                            <p>
                                or <button type="button" class="text-[#D4AF37] font-bold hover:text-[#B8860B]"
                                    @click="showCart = false">{{ __('Continue Shopping') }}<span aria-hidden="true">
                                        &rarr;</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail Modal -->
    <div x-show="selectedProduct" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="selectedProduct" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-[#4A3728]/60 backdrop-blur-sm transition-opacity"
                @click="selectedProduct = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="selectedProduct" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="absolute top-6 right-6 z-10">
                    <button @click="selectedProduct = null"
                        class="w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center text-[#4A3728] hover:text-[#D4AF37] transition-colors shadow-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div
                        class="w-full md:w-1/2 aspect-square md:aspect-auto overflow-hidden bg-[#F8F4ED] flex items-center justify-center">
                        <template x-if="!isDefaultImage(selectedProduct?.image)">
                            <img :src="selectedProduct?.image" :alt="selectedProduct?.name"
                                class="w-full h-full object-cover">
                        </template>
                        <template x-if="isDefaultImage(selectedProduct?.image)">
                            <div class="flex flex-col items-center gap-4">
                                <i class="fa-solid fa-cake-candles text-[#D4AF37] text-7xl opacity-50"></i>
                                <span
                                    class="text-xs text-[#8B5E3C]/30 font-black uppercase tracking-widest">{{ __('No Image Available') }}</span>
                            </div>
                        </template>
                    </div>

                    <!-- Details Section -->
                    <div class="w-full md:w-1/2 p-10 flex flex-col justify-between">
                        <div>
                            <span
                                class="inline-block px-4 py-1.5 rounded-full bg-[#8B5E3C]/10 text-[#8B5E3C] text-[10px] font-bold uppercase tracking-wider mb-4"
                                x-text="selectedProduct?.category"></span>
                            <h3 class="text-3xl md:text-4xl font-serif font-bold text-[#4A3728] mb-4"
                                x-text="selectedProduct?.name"></h3>
                            <p class="text-[#6B4F3A] leading-relaxed mb-8" x-text="selectedProduct?.description">
                            </p>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-8">
                                <span class="text-3xl font-bold text-[#8B5E3C]"
                                    x-text="formatPrice(selectedProduct?.price)"></span>
                            </div>

                            <button @click="addToCart(selectedProduct); selectedProduct = null"
                                class="w-full gold-pill text-white font-bold py-5 rounded-2xl shadow-lg shadow-[#D4AF37]/30 hover:scale-[1.02] transition-all flex items-center justify-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('Add to Cart') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Translations for JS -->
    <div id="translations" class="hidden" data-perfect-choice="{{ __('Perfect Choice!') }}"
        data-added-to-treats="{{ __('added to your treats.') }}" data-order-details="{{ __('Order Details') }}"
        data-what-is-name="{{ __('Full Name') }}" data-name-placeholder="{{ __('e.g., John Doe') }}"
        data-continue-wa="{{ __('Confirm Order') }}"
        data-name-validation="{{ __('We need your contact info to process the order!') }}"
        data-order-sent="{{ __('Order Placed!') }}"
        data-success-msg="{{ __('Your order has been recorded in our system. We will contact you shortly!') }}"
        data-order-confirmation="{{ __('Order Confirmation - Maryam Cake & Cookies') }}"
        data-customer="{{ __('Customer') }}" data-date="{{ __('Date') }}"
        data-items-label="{{ __('Items') }}" data-total-label="{{ __('Total') }}"
        data-process-msg="{{ __('Order received and processing.') }}"></div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Initialize Testimonial Swiper
        new Swiper(".testimonialSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });

        // Initialize Feature Swiper
        new Swiper(".featureSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    enabled: false, // Disable Swiper on Desktop, use Grid behavior
                },
            },
        });

        function cartApp() {
            const trans = document.getElementById('translations').dataset;

            return {
                cart: [],
                showCart: false,
                mobileMenuOpen: false,
                currentCategory: 'all',
                selectedProduct: null,
                voucherCode: '',
                appliedVoucher: null,
                discount: 0,
                selectedPayment: '',
                paymentMethods: @json($paymentMethods),
                shippingCost: {{ \App\Models\Setting::getValue('shipping_cost', 0) }},

                init() {
                    const savedCart = localStorage.getItem('maryam_cart');
                    if (savedCart) {
                        this.cart = JSON.parse(savedCart);
                    }
                },

                openProductModal(product) {
                    this.selectedProduct = product;
                },

                addToCart(product) {
                    const existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.cart.push({
                            ...product,
                            quantity: 1
                        });
                    }
                    this.saveCart();

                    Swal.fire({
                        title: trans.perfectChoice,
                        text: `${product.name} ${trans.addedToTreats}`,
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                },

                updateQty(id, delta) {
                    const item = this.cart.find(i => i.id === id);
                    if (!item) return;

                    item.quantity += delta;
                    if (item.quantity <= 0) {
                        this.removeFromCart(id);
                    } else {
                        this.saveCart();
                    }
                },

                removeFromCart(id) {
                    this.cart = this.cart.filter(i => i.id !== id);
                    this.saveCart();
                },

                saveCart() {
                    localStorage.setItem('maryam_cart', JSON.stringify(this.cart));
                },

                async applyVoucher() {
                    if (!this.voucherCode) return;

                    try {
                        const response = await fetch('{{ route('vouchers.check') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                code: this.voucherCode,
                                subtotal: this.subtotal
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.appliedVoucher = result.code;
                            this.discount = result.discount;
                            Swal.fire({
                                title: 'Success!',
                                text: result.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire('Error', result.message, 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Failed to check voucher.', 'error');
                    }
                },

                removeVoucher() {
                    this.appliedVoucher = null;
                    this.discount = 0;
                    this.voucherCode = '';
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get adminFee() {
                    const method = this.paymentMethods.find(m => m.name === this.selectedPayment);
                    return method ? parseFloat(method.admin_fee) : 0;
                },

                get totalPrice() {
                    return Math.max(0, this.subtotal - this.discount + this.adminFee + this.shippingCost);
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(price);
                },

                isDefaultImage(url) {
                    if (!url) return true;
                    return url.includes('default.jpg');
                },

                async checkout() {
                    if (!this.selectedPayment) {
                        Swal.fire({
                            title: '{{ __('Pilih Metode Pembayaran') }}',
                            text: '{{ __('Silakan pilih metode pembayaran terlebih dahulu.') }}',
                            icon: 'warning',
                            confirmButtonColor: '#D4AF37'
                        });
                        return;
                    }
                    const {
                        value: formValues
                    } = await Swal.fire({
                        title: trans.orderDetails,
                        html: `<div class="space-y-4 text-left">
                                <div>
                                    <label class="block text-sm font-bold text-[#8B5E3C] mb-1">${trans.whatIsName}</label>
                                    <input id="swal-input1" class="swal2-input w-full m-0 rounded-xl border-[#8B5E3C]/20" placeholder="${trans.namePlaceholder}">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-[#8B5E3C] mb-1">Nomor WhatsApp</label>
                                    <input id="swal-input2" class="swal2-input w-full m-0 rounded-xl border-[#8B5E3C]/20" placeholder="08123456789">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-[#8B5E3C] mb-1">Lokasi Pengiriman</label>
                                    <div id="map" style="height: 200px; width: 100%; border-radius: 0.75rem; border: 1px solid rgba(139, 94, 60, 0.2); z-index: 0;"></div>
                                    <button type="button" id="btn-location" class="mt-2 px-4 py-2 bg-[#8B5E3C] text-white text-xs font-bold rounded-lg hover:bg-[#D4AF37] transition-colors flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Gunakan Lokasi Saat Ini
                                    </button>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-[#8B5E3C] mb-1">Alamat Lengkap</label>
                                    <textarea id="swal-input3" class="swal2-textarea w-full m-0 rounded-xl border-[#8B5E3C]/20" style="height: 100px;" placeholder="Jl. Mawar No. 123, Jakarta"></textarea>
                                    <input type="hidden" id="swal-input-lat">
                                    <input type="hidden" id="swal-input-lng">
                                </div>
                            </div>`,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Konfirmasi Pesanan',
                        confirmButtonColor: '#4A3728',
                        didOpen: () => {
                            // Initialize Map
                            const map = L.map('map').setView([-6.2088, 106.8456], 13); // Default Jakarta
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            let marker;

                            const updateMarker = (lat, lng) => {
                                if (marker) {
                                    marker.setLatLng([lat, lng]);
                                } else {
                                    marker = L.marker([lat, lng]).addTo(map);
                                }
                                map.setView([lat, lng], 16);
                                document.getElementById('swal-input-lat').value = lat;
                                document.getElementById('swal-input-lng').value = lng;

                                // Reverse Geocode
                                Swal.showLoading();
                                fetch(
                                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`
                                    )
                                    .then(response => response.json())
                                    .then(data => {
                                        Swal.hideLoading();
                                        if (data && data.display_name) {
                                            document.getElementById('swal-input3').value = data
                                                .display_name;
                                        }
                                    })
                                    .catch(() => {
                                        Swal.hideLoading();
                                    });
                            };

                            map.on('click', function(e) {
                                updateMarker(e.latlng.lat, e.latlng.lng);
                            });

                            document.getElementById('btn-location').addEventListener('click', () => {
                                if (navigator.geolocation) {
                                    Swal.showLoading();
                                    navigator.geolocation.getCurrentPosition((position) => {
                                        Swal.hideLoading();
                                        updateMarker(position.coords.latitude, position
                                            .coords
                                            .longitude);
                                    }, (error) => {
                                        Swal.hideLoading();
                                        Swal.showValidationMessage(
                                            'Gagal mendapatkan lokasi: ' +
                                            error.message);
                                    });
                                } else {
                                    Swal.showValidationMessage(
                                        'Geolocation tidak didukung browser ini.');
                                }
                            });
                        },
                        preConfirm: () => {
                            const name = document.getElementById('swal-input1').value;
                            const phone = document.getElementById('swal-input2').value;
                            const address = document.getElementById('swal-input3').value;
                            const lat = document.getElementById('swal-input-lat').value;
                            const lng = document.getElementById('swal-input-lng').value;

                            if (!name || !phone || !address) {
                                Swal.showValidationMessage('Semua data harus diisi');
                                return false;
                            }
                            return {
                                name,
                                phone,
                                address,
                                lat,
                                lng
                            };
                        }
                    });

                    if (formValues) {
                        try {
                            Swal.fire({
                                title: 'Sedang Memproses...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            const response = await fetch('{{ route('checkout') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    customer_name: formValues.name,
                                    customer_phone: formValues.phone,
                                    address: formValues.address,
                                    cart: this.cart,
                                    voucher_code: this.appliedVoucher,
                                    payment_method: this.selectedPayment,
                                    latitude: formValues.lat,
                                    longitude: formValues.lng
                                })
                            });

                            const result = await response.json();

                            if (result.success) {
                                // Prepare WhatsApp Message for secondary notification (optional but good)
                                let message = `*Konfirmasi Pesanan #${result.order_number}*\n\n`;
                                message += `*Nama:* ${formValues.name}\n`;
                                message += `*Phone:* ${formValues.phone}\n\n`;
                                message += `*Item:* \n`;
                                this.cart.forEach(item => {
                                    message += `- ${item.name} (${item.quantity}x)\n`;
                                });
                                message += `\n*Total:* ${this.formatPrice(this.totalPrice)}\n\n`;
                                message += `Lanjutkan ke WhatsApp untuk tanya-tanya?`;

                                const waUrl = `https://wa.me/6281234567890?text=${encodeURIComponent(message)}`;

                                Swal.fire({
                                    title: '{{ __('Order placed successfully!') }}',
                                    html: `
                                        <div class="text-center">
                                            <p class="mb-4 text-[#6B4F3A]">${'{{ __('Order Number') }}'}: <span class="font-black text-[#D4AF37]">${result.order_number}</span></p>
                                            <div class="flex flex-col gap-3">
                                                <a href="${result.invoice_url}" id="download-invoice-btn" target="_blank" class="flex items-center justify-center px-6 py-4 bg-[#8B5E3C] text-white rounded-2xl font-bold hover:bg-[#D4AF37] transition-all shadow-lg shadow-[#8B5E3C]/20">
                                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    ${'{{ __('Unduh Invoice (PDF)') }}'}
                                                </a>
                                                <p class="text-[10px] text-[#8B5E3C]/60 uppercase tracking-widest font-bold">${'{{ __('Save this invoice for tracking via QR Code') }}'}</p>
                                            </div>
                                            <div id="after-download-actions" class="hidden mt-6 pt-6 border-t border-[#8B5E3C]/10 flex flex-col gap-3">
                                               <p class="text-sm font-medium text-green-600 mb-2 flex items-center justify-center gap-2">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Invoice Berhasil Diunduh
                                               </p>
                                            </div>
                                        </div>
                                    `,
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    confirmButtonText: '{{ __('Lanjutkan ke WhatsApp') }}',
                                    cancelButtonText: '{{ __('Close') }}',
                                    confirmButtonColor: '#25D366',
                                    customClass: {
                                        popup: 'rounded-[2.5rem]',
                                        confirmButton: 'rounded-xl px-6 py-3 font-bold',
                                        cancelButton: 'rounded-xl px-6 py-3 font-bold'
                                    },
                                    didOpen: () => {
                                        const btn = document.getElementById('download-invoice-btn');
                                        btn.addEventListener('click', () => {
                                            // Show the swal action buttons after a small delay
                                            setTimeout(() => {
                                                Swal.update({
                                                    showConfirmButton: true,
                                                    showCancelButton: true
                                                });
                                                document.getElementById(
                                                        'after-download-actions').classList
                                                    .remove('hidden');
                                            }, 1000);
                                        });
                                    }
                                }).then((swalResult) => {
                                    if (swalResult.isConfirmed) {
                                        window.open(waUrl, '_blank');
                                    }
                                });

                                this.cart = [];
                                this.saveCart();
                                this.showCart = false;
                            } else {
                                const errorData = await response.json();
                                let errorMessage = 'Gagal membuat pesanan';
                                if (errorData.message) {
                                    if (typeof errorData.message === 'object') {
                                        errorMessage = Object.values(errorData.message).flat().join('\n');
                                    } else {
                                        errorMessage = errorData.message;
                                    }
                                }
                                throw new Error(errorMessage);
                            }
                        } catch (error) {
                            Swal.fire('Error', error.message, 'error');
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>
