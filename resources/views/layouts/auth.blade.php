<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RootED — Culturally Relevant Learning')</title>
    <meta name="description" content="@yield('meta_description', 'RootED is a localization-aware, culturally-filtered Learning Management System built for West African education. Discover courses presented in your language and cultural framing.')">

    <!-- SEO & Accessibility -->
    <meta name="theme-color" content="#FAF6F0">
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Tailwind & Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-brand-cream font-sans text-brand-charcoal selection:bg-brand-terracotta selection:text-white antialiased overflow-x-hidden relative flex flex-col justify-between">
    
    <!-- West African Chevron Border Accent Top -->
    <div class="h-2 w-full chevron-bg z-10"></div>

    <!-- Organic background dot/grid motif -->
    <div class="absolute inset-0 motif-bg-grid pointer-events-none"></div>

    <!-- Main Container -->
    <main class="relative z-10 flex-1 flex flex-col justify-center py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 text-center py-6 text-xs text-brand-charcoal/60 border-t border-brand-charcoal/10 bg-brand-cream/65 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>&copy; {{ date('Y') }} RootED. Developed for West African Multilingual Education.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-brand-terracotta transition-colors duration-200">Help</a>
                <a href="#" class="hover:text-brand-terracotta transition-colors duration-200">Terms</a>
                <a href="#" class="hover:text-brand-terracotta transition-colors duration-200">Privacy</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
