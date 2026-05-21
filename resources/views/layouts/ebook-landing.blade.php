<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Ebook</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Scripts/Styles -->
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
        .book-shadow {
            box-shadow: 20px 20px 60px #d9d8d4, -20px -20px 60px #ffffff;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="py-6 px-4 md:px-12 flex justify-between items-center border-b border-gray-100">
        <a href="/" class="serif text-xl font-semibold italic text-gray-700">Reflexiones de Vida</a>
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-600 underline">Panel</a>
                @endauth
            </div>
        @endif
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-12 md:py-20">
        @yield('content')
    </main>

    <footer class="py-12 border-t border-gray-100 text-center text-gray-500 text-sm">
        <p class="serif italic mb-2">"Ese hombre es como un árbol plantado a la orilla de un río,
            que da su fruto a su tiempo y jamás se marchitan sus hojas. ¡Todo lo que hace, le sale bien!"
        </p>
        <p>&copy; {{ date('Y') }} - {{ config('app.name') }}</p>
    </footer>
</body>
</html>
