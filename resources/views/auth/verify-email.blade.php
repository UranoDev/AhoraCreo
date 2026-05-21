@extends('layouts.ebook-landing')

@section('title', __('Verifica tu correo'))

@section('content')
    <section class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div>
            <p class="serif italic text-[#B8860B] mb-4">
                {{ __('Tu libro esta casi listo') }}
            </p>

            <h1 class="serif text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                {{ __('Confirma tu correo para recibir la descarga') }}
            </h1>

            <p class="text-lg text-gray-600 leading-relaxed serif">
                {{ __('Te enviamos un enlace de verificacion. Abre tu correo y confirma tu direccion para continuar con el envio del libro.') }}
            </p>
        </div>

        <div class="bg-white p-8 md:p-10 rounded-sm border border-gray-100 shadow-sm">
            <div class="mb-8 border-l-2 border-[#B8860B]/40 pl-5">
                <h2 class="serif text-2xl font-semibold text-gray-900 mb-3">
                    {{ __('Revisa tu bandeja de entrada') }}
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    {{ __('Si no encuentras el mensaje, revisa spam o solicita un nuevo enlace aqui mismo.') }}
                </p>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-sm text-green-700 text-sm italic serif">
                    {{ __('Hemos enviado un nuevo enlace de verificacion al correo que proporcionaste durante el registro.') }}
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-4 px-6 btn-gold font-semibold rounded-sm transition duration-300 uppercase tracking-widest text-xs"
                    >
                        {{ __('Reenviar enlace de verificacion') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-3 px-4 text-gray-600 hover:text-gray-900 text-sm underline underline-offset-4"
                    >
                        {{ __('Cerrar sesion') }}
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
