<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Get Your Free Book') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans">

    {{-- Top Bar --}}
    <div class="h-1 bg-teal-500"></div>

    {{-- Navigation --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5zM8 13h8v2H8v-2zm0 4h5v2H8v-2z"/>
                </svg>
                <span class="text-xl font-bold text-gray-800 tracking-tight">{{ config('app.name') }}</span>
            </a>
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-teal-500 transition">{{ __('Features') }}</a>
                <a href="#about" class="hover:text-teal-500 transition">{{ __('About') }}</a>
                <a href="{{ route('login') }}" class="hover:text-teal-500 transition">{{ __('Login') }}</a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative bg-gray-900 overflow-hidden">
        {{-- Background overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/80 to-gray-900/60"></div>
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 py-20 md:py-28">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                {{-- Left: Text Content --}}
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        {{ __('Get Your') }}
                        <span class="text-teal-400">{{ __('Free Book') }}</span>
                        {{ __('Today') }}
                    </h1>
                    <p class="text-lg text-gray-300 leading-relaxed mb-8">
                        {{ __('Discover the secrets to success in our exclusive guide. Enter your email and get instant access to the full PDF — completely free, no strings attached.') }}
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#features" class="inline-flex items-center px-6 py-3 border-2 border-white/30 text-white rounded-full hover:bg-white/10 transition font-medium">
                            {{ __('Learn More') }}
                        </a>
                        <a href="#signup" class="inline-flex items-center px-6 py-3 bg-teal-500 text-white rounded-full hover:bg-teal-400 transition font-bold shadow-lg shadow-teal-500/30">
                            {{ __('Get Started Now') }}
                        </a>
                    </div>
                </div>

                {{-- Right: Sign Up Form --}}
                <div id="signup">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10">
                        <h2 class="text-xl font-bold text-gray-800 text-center mb-6 uppercase tracking-wide">
                            {{ __('Sign Up to Get Your Free Book!') }}
                        </h2>

                        {{-- Flash Messages --}}
                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm text-center">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 text-sm text-center">
                                {{ session('info') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm text-center">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('subscribe') }}" class="space-y-4">
                            @csrf
                            <div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="{{ __('Enter your email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                >
                                @error('email')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <p class="text-xs text-gray-500 text-center">
                                {{ __('By signing up, you agree to our') }}
                                <a href="#" class="text-teal-500 hover:underline">{{ __('Terms of Service') }}</a>
                                {{ __('and') }}
                                <a href="#" class="text-teal-500 hover:underline">{{ __('Privacy Policy') }}</a>
                            </p>

                            <button
                                type="submit"
                                class="w-full py-3 px-6 bg-teal-500 hover:bg-teal-400 text-white font-bold rounded-full transition duration-200 shadow-lg shadow-teal-500/30 uppercase tracking-wide"
                            >
                                {{ __('Get My Free Book') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Feature 1 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('Instant Delivery') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('Enter your email and receive a verification link instantly. Once verified, the book arrives in your inbox within seconds.') }}
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('Quality Content') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('Our carefully crafted guide is packed with actionable insights, real-world examples, and proven strategies you can apply right away.') }}
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('Easy Download') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('Get the PDF attached to your email or use the direct download link. Read it on any device, anytime, anywhere.') }}
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('100% Free') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('No hidden fees, no credit card required. Just your email address and the book is yours to keep forever.') }}
                    </p>
                </div>

                {{-- Feature 5 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('Secure & Private') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('Your email is safe with us. We never share your data with third parties and you won\'t receive spam. Ever.') }}
                    </p>
                </div>

                {{-- Feature 6 --}}
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 uppercase tracking-wide">{{ __('Practical Tips') }}</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        {{ __('Every chapter includes hands-on exercises and step-by-step instructions so you can start implementing ideas right away.') }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('About This Book') }}</h2>
            <div class="w-16 h-1 bg-teal-500 mx-auto mb-8 rounded-full"></div>
            <p class="text-lg text-gray-500 leading-relaxed mb-8">
                {{ __('This book is a comprehensive guide designed to help you achieve your goals faster and more efficiently. Whether you\'re just starting out or looking to level up, you\'ll find valuable insights and proven methods inside.') }}
            </p>
            <a href="#signup" class="inline-flex items-center px-8 py-3 bg-teal-500 text-white rounded-full hover:bg-teal-400 transition font-bold shadow-lg shadow-teal-500/30 uppercase tracking-wide">
                {{ __('Download Now — It\'s Free') }}
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <p class="text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                </p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="hover:text-teal-400 transition">{{ __('Terms of Service') }}</a>
                    <a href="#" class="hover:text-teal-400 transition">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-teal-400 transition">{{ __('Contact') }}</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
