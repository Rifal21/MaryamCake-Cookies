<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Maryam Cake - Login') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FDFBF7;
            background-image:
                radial-gradient(at 0% 0%, rgba(212, 175, 55, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 94, 60, 0.05) 0px, transparent 50%);
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
        }

        .premium-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 94, 60, 0.1);
        }
    </style>
</head>

<body class="antialiased text-[#4A3728]">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="mb-8">
            <a href="/" class="text-4xl font-serif font-bold tracking-tighter text-[#8B5E3C]">
                Maryam <span class="text-[#D4AF37]">Cake & Cookies</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 premium-card shadow-2xl overflow-hidden sm:rounded-[2rem]">
            {{ $slot }}
        </div>

        <div class="mt-8 text-sm text-[#8B5E3C]/60">
            &copy; {{ date('Y') }} Maryam Cake and Cookies. All rights reserved.
        </div>
    </div>
</body>

</html>
