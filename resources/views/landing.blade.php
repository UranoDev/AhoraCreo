@extends('layouts.ebook-landing')

@section('title', __('Get Your Free Book'))

@section('content')
    @php
        $bookCoverPath = storage_path('ebooks/portada.jpeg');
        $hasBookCover = file_exists($bookCoverPath);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        {{-- Left: Book Presentation --}}
        <div class="order-2 md:order-1">
            <div class="relative max-w-sm mx-auto md:mx-0">
                @if ($hasBookCover)
                    <img
                        src="{{ route('ebook.cover') }}"
                        alt="{{ __('Portada del libro') }}"
                        class="aspect-[2/3] w-full rounded-sm border border-gray-200 object-cover book-shadow"
                    >
                @else
                {{-- Book Cover Placeholder --}}
                <div class="aspect-[2/3] bg-white border border-gray-200 book-shadow flex flex-col items-center justify-center p-8 text-center">
                    <div class="border-2 border-gray-100 w-full h-full flex flex-col items-center justify-between py-12 px-4">
                        <p class="serif italic text-gray-400 text-sm">Reflexiones de Esperanza</p>
                        <h2 class="serif text-3xl font-bold text-gray-800">El Camino a la Paz Interior</h2>
                        <div class="w-12 h-px bg-gray-200"></div>
                        <p class="text-xs uppercase tracking-widest text-gray-500">Una guía espiritual</p>
                    </div>
                </div>
                @endif
                {{-- Quote decoration --}}
                <div class="absolute -bottom-8 -right-8 hidden lg:block w-48 p-4 bg-white italic serif text-gray-500 text-sm border-l-2 border-[#B8860B]/30">
                    "Encontré la paz donde menos la esperaba..."
                </div>
            </div>
        </div>

        {{-- Right: Text & Form --}}
        <div class="order-1 md:order-2">
            <h1 class="serif text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                {{ __('Descubre la sabiduría que transforma el corazón') }}
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-8 serif">
                {{ __('Un relato honesto sobre la superación, la fe y el encuentro con Jesucristo después de las tormentas de la vida.') }}
            </p>

            <div class="bg-white p-8 rounded-sm border border-gray-100 shadow-sm">
                <h3 class="serif text-xl font-semibold mb-6 text-gray-800">{{ __('Recibe este libro en tu correo') }}</h3>

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded text-green-700 text-sm italic serif">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded text-blue-700 text-sm italic serif">
                        {{ session('info') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-sm italic serif">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('subscribe') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="sr-only">{{ __('Correo electrónico') }}</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="{{ __('Tu mejor correo electrónico') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-transparent transition serif"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-500 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (config('services.recaptcha.site_key'))
                        <div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @error('g-recaptcha-response')
                                <p class="mt-2 text-sm text-red-500 italic">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <button
                        type="submit"
                        class="w-full py-4 px-6 btn-gold font-semibold rounded-sm transition duration-300 uppercase tracking-widest text-xs"
                    >
                        {{ __('Quiero descargar el libro gratis') }}
                    </button>
                </form>
                <p class="text-[10px] text-gray-400 mt-4 text-center uppercase tracking-tighter">
                    {{ __('Privacidad garantizada. No enviamos spam.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- About/Testimonial Section --}}
    <section class="mt-32 pt-20 border-t border-gray-100">
        <div class="max-w-3xl mx-auto text-left">
            <h2 class="serif text-3xl font-bold text-gray-900 mb-8">{{ __('Acerca de esta obra') }}</h2>
            <div class="prose prose-gray mx-auto text-gray-600 serif italic leading-relaxed">
                <p class="mb-6">
                    La historia que encierran estas páginas es una parte importante de la vida de la escritora, en la que los lectores pudieran encontrar alguna similitud con la suya, de no ser así, de cualquier manera le resultará muy interesante; lleva también el objetivo de dar a conocer como el amor de Jesucristo transformó una vida de mucho sufrimiento, de lucha incansable por salir adelante, de resistir los embates de la adversidad, de caminar con el peso de la derrota y las decepciones; de como un corazón roto y sin esperanza, al fortalecer la fe, en forma casi mágica e imperceptible, se fue transformando en algo muy difícil de explicar; pero que llena la mente, el cuerpo y el espíritu de esa paz que muchos buscan en los lugares equivocados.
                    Al menos por curiosidad, te recomendamos que lo leas y tal vez, sólo tal vez encuentrres lo mismo que la autora encontró y que le llevó hacia lo que siempre ha buscado el hombre, lo más parecido a la felicidad y que por experiencia te confirmamos que solamente encontrarás en Jesucristo.
                </p>
            </div>
        </div>
    </section>
@endsection

@if (config('services.recaptcha.site_key'))
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endif

