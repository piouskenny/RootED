<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RootED — Learning Dashboard')</title>
    <meta name="description" content="RootED is a localization-aware, culturally-filtered Learning Management System built for West African education. Discover courses presented in your language and cultural framing.">

    <!-- SEO & Theme -->
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
    <div class="h-2 w-full chevron-bg z-30"></div>

    <!-- Organic background dot/grid motif -->
    <div class="absolute inset-0 motif-bg-grid pointer-events-none"></div>

    <!-- Sticky Navigation Header -->
    <header class="sticky top-0 z-20 w-full bg-brand-cream/80 backdrop-blur-md border-b-2 border-brand-charcoal px-4 py-3 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Left: Brand Logo & Navigation Links -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="/dashboard" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-full bg-brand-charcoal text-brand-cream flex items-center justify-center font-bold text-lg neo-border group-hover:scale-105 transition-transform duration-200">
                        M
                    </div>
                    <span class="font-serif text-2xl font-bold tracking-tight text-brand-charcoal">RootED</span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1">
                    @php $role = auth()->check() ? auth()->user()->role : 'learner'; @endphp
                    @if($role === 'instructor')
                        <a href="/dashboard" class="bg-brand-charcoal/5 border border-brand-charcoal/10 rounded-lg px-4 py-1.5 font-bold text-sm text-brand-charcoal">
                            Dashboard
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            My courses
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Content editor
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Students
                        </a>
                    @elseif($role === 'admin')
                        <a href="/dashboard" class="bg-brand-charcoal/5 border border-brand-charcoal/10 rounded-lg px-4 py-1.5 font-bold text-sm text-brand-charcoal">
                            Users
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Culture tags
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Locales
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Audit log
                        </a>
                        <a href="/dashboard" class="bg-brand-charcoal/5 border border-brand-charcoal/10 rounded-lg px-4 py-1.5 font-bold text-sm text-brand-charcoal">
                            Dashboard
                        </a>
                        <a href="/dashboard#recommendations" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Catalogue
                        </a>
                        <a href="/dashboard#recommendations" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Courses
                        </a>
                        <a href="#" class="px-4 py-1.5 font-semibold text-sm text-brand-charcoal/60 hover:text-brand-charcoal hover:bg-brand-charcoal/5 rounded-lg transition-all duration-150">
                            Discussion
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Right: Dynamic Controls & Profile -->
            <div class="flex items-center gap-3">
                
                <!-- Cultural Framing Tag (Matches the "EARTH (TERRACOTTA)" badge in mockup) -->
                <div class="hidden xl:flex items-center gap-2 px-4 py-1.5 bg-brand-cream border-2 border-brand-charcoal rounded-full text-xs font-bold uppercase tracking-wider shadow-sm" id="navCulturalTag">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-brand-terracotta animate-pulse" id="navCulturalDot"></span>
                    <span id="navCulturalLabel">EARTH (TERRACOTTA)</span>
                </div>

                <!-- Locale Toggle -->
                <div class="relative inline-block text-left" id="navLocaleContainer">
                    <button type="button" id="navLocaleBtn" class="flex items-center gap-1.5 px-3 py-1.5 bg-brand-cream border-2 border-brand-charcoal shadow-sm rounded-lg text-xs font-bold hover:bg-brand-cream/80 transition-all duration-150">
                        <span id="navLocaleLabel">{{ strtoupper(app()->getLocale() ?: 'EN') }}</span>
                        <svg class="w-3 h-3 text-brand-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div id="navLocaleMenu" class="hidden absolute right-0 mt-2 w-32 bg-white neo-border neo-shadow-sm rounded-xl py-1 z-50">
                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" class="block w-full text-left px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">English</a>
                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'yo']) }}" class="block w-full text-left px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">Yorùbá</a>
                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'ha']) }}" class="block w-full text-left px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">Hausa</a>
                        <a href="{{ request()->fullUrlWithQuery(['locale' => 'ig']) }}" class="block w-full text-left px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">Igbo</a>
                    </div>
                </div>

                <!-- Role Selector (Learner/Instructor/Admin) Segmented control -->
                <div class="hidden md:flex p-0.5 bg-brand-cream border-2 border-brand-charcoal rounded-xl relative shadow-sm">
                    @php $role = auth()->check() ? auth()->user()->role : 'learner'; @endphp
                    <button type="button" class="py-1 px-3 text-xs font-bold rounded-lg {{ $role === 'learner' ? 'bg-brand-charcoal text-white border border-brand-charcoal' : 'text-brand-charcoal/60 hover:bg-brand-charcoal/5' }}">
                        Learner
                    </button>
                    <button type="button" class="py-1 px-3 text-xs font-bold rounded-lg {{ $role === 'instructor' ? 'bg-brand-charcoal text-white border border-brand-charcoal' : 'text-brand-charcoal/60 hover:bg-brand-charcoal/5' }}">
                        Instructor
                    </button>
                    <button type="button" class="py-1 px-3 text-xs font-bold rounded-lg {{ $role === 'admin' ? 'bg-brand-charcoal text-white border border-brand-charcoal' : 'text-brand-charcoal/60 hover:bg-brand-charcoal/5' }}">
                        Admin
                    </button>
                </div>

                <!-- User Profile & Sign Out Dropdown -->
                <div class="relative inline-block text-left" id="navProfileContainer">
                    <button type="button" id="navProfileBtn" class="w-9 h-9 rounded-full bg-brand-terracotta text-white flex items-center justify-center font-bold text-sm border-2 border-brand-charcoal hover:scale-105 active:scale-95 transition-all duration-150">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'A' }}
                    </button>
                    <!-- Profile Menu Dropdown -->
                    <div id="navProfileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white neo-border neo-shadow rounded-xl py-1.5 z-50">
                        <div class="px-4 py-2 border-b border-brand-charcoal/10">
                            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Signed in as</p>
                            <p class="text-sm font-bold text-brand-charcoal truncate">{{ auth()->check() ? auth()->user()->name : 'Adaeze Nwachukwu' }}</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">Profile settings</a>
                        <a href="#" class="block px-4 py-2 text-xs font-bold hover:bg-brand-cream text-brand-charcoal transition-colors">My Certificates</a>
                        <div class="border-t border-brand-charcoal/10 my-1"></div>
                        
                        <!-- Logout Action Form -->
                        <form action="{{ route('logout') }}" method="POST" class="block w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-brand-terracotta hover:bg-brand-cream transition-colors cursor-pointer">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <button type="button" id="mobileMenuBtn" class="lg:hidden w-9 h-9 bg-brand-cream border-2 border-brand-charcoal rounded-lg flex items-center justify-center hover:bg-brand-cream/80 active:translate-y-0.5 transition-all duration-150">
                    <svg class="w-5 h-5 text-brand-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                </button>

            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden lg:hidden mt-3 border-t border-brand-charcoal/10 pt-3 animate-in slide-in-from-top-2 duration-150">
            <nav class="flex flex-col gap-2">
                @php $role = auth()->check() ? auth()->user()->role : 'learner'; @endphp
                @if($role === 'instructor')
                    <a href="/dashboard" class="bg-brand-charcoal/5 rounded-lg px-4 py-2 font-bold text-sm text-brand-charcoal">Dashboard</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">My courses</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Content editor</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Students</a>
                @elseif($role === 'admin')
                    <a href="/dashboard" class="bg-brand-charcoal/5 rounded-lg px-4 py-2 font-bold text-sm text-brand-charcoal">Users</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Culture tags</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Locales</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Audit log</a>
                @else
                    <a href="/dashboard" class="bg-brand-charcoal/5 rounded-lg px-4 py-2 font-bold text-sm text-brand-charcoal">Dashboard</a>
                    <a href="/dashboard#recommendations" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Catalogue</a>
                    <a href="/dashboard#recommendations" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Courses</a>
                    <a href="#" class="px-4 py-2 font-semibold text-sm text-brand-charcoal/70 rounded-lg hover:bg-brand-charcoal/5">Discussion</a>
                @endif
                <div class="border-t border-brand-charcoal/10 my-2"></div>
                <div class="flex items-center justify-between px-4 py-2">
                    <span class="text-xs font-bold text-brand-charcoal/50">Active Role</span>
                    <div class="flex p-0.5 bg-brand-cream border-2 border-brand-charcoal rounded-xl text-xs font-bold">
                        <button class="py-1 px-3 rounded-lg {{ $role === 'learner' ? 'bg-brand-charcoal text-white' : 'text-brand-charcoal/60' }}">Learner</button>
                        <button class="py-1 px-3 rounded-lg {{ $role === 'instructor' ? 'bg-brand-charcoal text-white' : 'text-brand-charcoal/60' }}">Instructor</button>
                        <button class="py-1 px-3 rounded-lg {{ $role === 'admin' ? 'bg-brand-charcoal text-white' : 'text-brand-charcoal/60' }}">Admin</button>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content Grid -->
    <main class="relative z-10 flex-1 py-8 px-4 sm:px-6 lg:px-8">
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

    <!-- Header Dropdown Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Locale dropdown
            const navLocaleBtn = document.getElementById('navLocaleBtn');
            const navLocaleMenu = document.getElementById('navLocaleMenu');
            if (navLocaleBtn && navLocaleMenu) {
                navLocaleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    navLocaleMenu.classList.toggle('hidden');
                    if (navProfileMenu) navProfileMenu.classList.add('hidden');
                });
            }

            // Profile dropdown
            const navProfileBtn = document.getElementById('navProfileBtn');
            const navProfileMenu = document.getElementById('navProfileMenu');
            if (navProfileBtn && navProfileMenu) {
                navProfileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    navProfileMenu.classList.toggle('hidden');
                    if (navLocaleMenu) navLocaleMenu.classList.add('hidden');
                });
            }

            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Global click outside to hide menus
            document.addEventListener('click', () => {
                if (navLocaleMenu) navLocaleMenu.classList.add('hidden');
                if (navProfileMenu) navProfileMenu.classList.add('hidden');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
