@extends('layouts.ebook-landing')

@section('title', __('Correo verificado'))

@section('content')
    <section class="max-w-2xl mx-auto text-center">
        <div class="bg-white border border-gray-100 shadow-sm px-6 py-10 md:px-10 md:py-12 rounded-sm">
            <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-sm border border-green-200 bg-green-50">
                <svg class="h-8 w-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <p class="serif italic text-[#B8860B] mb-3">
                {{ __('Verificacion completada') }}
            </p>

            <h1 class="serif text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-5">
                {{ __('Tu libro esta en camino') }}
            </h1>

            <p class="text-gray-600 leading-relaxed mb-8">
                {{ __('Revisa tu bandeja de entrada. Te enviamos un correo con el PDF adjunto y un enlace de descarga.') }}
            </p>

            <a
                href="{{ route('landing') }}"
                class="inline-flex items-center justify-center py-4 px-6 btn-gold font-semibold rounded-sm transition duration-300 uppercase tracking-widest text-xs"
            >
                {{ __('Volver al inicio') }}
            </a>
        </div>
    </section>
@endsection
