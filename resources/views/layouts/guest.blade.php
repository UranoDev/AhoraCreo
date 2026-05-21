<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #FDFCF8;
                color: #2D3748;
            }
            .serif {
                font-family: 'Lora', serif;
            }
            .btn-gold {
                background-color: #B8860B;
                color: white;
                transition: all 0.3s ease;
            }
            .btn-gold:hover {
                background-color: #966D09;
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col">
            <nav class="py-6 px-4 md:px-12 flex justify-between items-center border-b border-gray-100">
                <a href="/" class="serif text-xl font-semibold italic text-gray-700">Reflexiones de Vida</a>
                <a href="{{ route('landing') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Inicio') }}
                </a>
            </nav>

            <main class="flex-1 flex items-center justify-center px-4 py-12 md:py-20">
                <div class="w-full sm:max-w-md bg-white border border-gray-100 shadow-sm px-6 py-8 md:px-8 md:py-10 rounded-sm">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-8 border-t border-gray-100 text-center text-gray-500 text-sm">
                <p class="serif italic mb-2">"La sabiduria es un arbol de vida a los que de ella echan mano."</p>
                <p>&copy; {{ date('Y') }} - {{ config('app.name') }}</p>
            </footer>
        </div>
    </body>
</html>
