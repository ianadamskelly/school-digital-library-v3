<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Library - Explorer Hub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:400,600,700" rel="stylesheet" />
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e3a8a">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('pwa-install.js') }}" defer></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Service Worker registered', reg))
                    .catch(err => console.log('Service Worker registration failed', err));
            });
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(30, 58, 138, 0.6) 100%), url('/hero.png');
            background-size: cover;
            background-position: center;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 p-6 flex justify-between items-center transition-all duration-300" id="navbar">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg"
                style="width: 40px; height: 40px;">
                <svg class="w-6 h-6" width="24" height="24" style="width: 24px; height: 24px;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight text-white drop-shadow-md">Digital Library</span>
        </div>
        <div class="space-x-4 flex items-center">
            <button id="pwa-install-btn" style="display: none;"
                class="px-4 py-2 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition shadow-lg text-sm">
                Install App
            </button>
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="px-6 py-2 bg-white text-blue-900 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white font-medium hover:text-blue-200 transition">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-6 py-2 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition shadow-lg border border-blue-400">Join
                        Now</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="h-screen hero-gradient flex items-center justify-center p-6 lg:p-20 relative">
        <div class="max-w-4xl text-center text-white space-y-6 animate-fade-in-up">
            <h1 class="text-5xl lg:text-7xl font-bold leading-tight">Ignite the Joy of Reading in Every Child</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Explore thousands of stories, learn with high-quality AI
                narration, and track your progress in a magical digital world.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-6">
                <a href="{{ route('register') }}"
                    class="px-10 py-4 bg-white text-blue-900 rounded-full text-lg font-bold hover:scale-105 transition-all shadow-xl">Get
                    Started for Free</a>
                <a href="#features"
                    class="px-10 py-4 glass text-white rounded-full text-lg font-bold hover:bg-white/20 transition-all">Learn
                    More</a>
            </div>
        </div>

        <!-- Animated Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce opacity-70">
            <svg class="w-6 h-6 text-white" width="24" height="24" style="width: 24px; height: 24px;" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 px-6 lg:px-20 bg-white">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="p-8 rounded-3xl bg-blue-50 space-y-4 hover:shadow-2xl transition duration-500">
                <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white"
                    style="width: 56px; height: 56px;">
                    <svg class="w-8 h-8" width="32" height="32" style="width: 32px; height: 32px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Read Aloud Engine</h3>
                <p class="text-gray-600">Our smart AI narrators bring stories to life, helping kids improve their
                    vocabulary and listening skills.</p>
            </div>
            <div class="p-8 rounded-3xl bg-indigo-50 space-y-4 hover:shadow-2xl transition duration-500">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white"
                    style="width: 56px; height: 56px;">
                    <svg class="w-8 h-8" width="32" height="32" style="width: 32px; height: 32px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Track Progress</h3>
                <p class="text-gray-600">Teachers and parents can see exactly how many books their little ones have
                    finished this year.</p>
            </div>
            <div class="p-8 rounded-3xl bg-purple-50 space-y-4 hover:shadow-2xl transition duration-500">
                <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center text-white"
                    style="width: 56px; height: 56px;">
                    <svg class="w-8 h-8" width="32" height="32" style="width: 32px; height: 32px;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold">Teacher Tools</h3>
                <p class="text-gray-600">Easily upload PDFs and manage your school library with powerful administration
                    features.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-blue-900 py-20 px-6 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Ready to start the adventure?</h2>
        <a href="{{ route('register') }}"
            class="inline-block px-12 py-5 bg-blue-600 rounded-full text-xl font-bold hover:bg-blue-500 transition shadow-2xl">Create
            Your Account</a>
    </section>

    <footer class="py-12 px-6 border-t border-gray-200 text-center text-gray-400">
        <p>&copy; 2026 Digital School Library. Built for the next generation of readers.</p>
    </footer>

    <script>
        // Sticky Navbar with background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('bg-blue-900/90', 'backdrop-blur-md', 'shadow-lg');
            } else {
                nav.classList.remove('bg-blue-900/90', 'backdrop-blur-md', 'shadow-lg');
            }
        });
    </script>
</body>

</html>