<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Email Verified') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-800 via-emerald-900 to-teal-900 min-h-screen flex items-center justify-center">

<div class="max-w-lg mx-auto px-6 py-12 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-400/20 rounded-full mb-6">
        <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-white mb-4">
        {{ __('Email Verified Successfully!') }}
    </h1>

    <p class="text-emerald-200 mb-6">
        {{ __('Your book is on its way! Check your inbox for an email with the PDF attached and a download link.') }}
    </p>

    <a href="{{ route('landing') }}"
       class="inline-block py-3 px-8 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-xl transition">
        {{ __('← Back to Home') }}
    </a>
</div>

</body>
</html>
