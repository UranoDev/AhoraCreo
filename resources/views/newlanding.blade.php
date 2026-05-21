<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Un Camino a la Esperanza') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 font-sans">

<div class="h-1 bg-amber-500"></div>

<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <span class="text-xl font-bold tracking-tight">{{ config('app.name') }}</span>
        <div class="hidden md:flex space-x-6 text-sm">
            <a href="#sinopsis" class="hover:text-amber-500">Sinopsis</a>
            <a href="#mensaje" class="hover:text-amber-500">Mensaje</a>
            <a href="#signup" class="hover:text-amber-500">Obtener</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="bg-gray-900 text-white py-24">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-5xl font-bold leading-tight mb-6">
                Una historia real de dolor, fe y transformación
            </h1>
            <p class="text-gray-300 mb-8 text-lg">
                Un testimonio que revela cómo incluso en los momentos más oscuros, la esperanza puede florecer.
            </p>
            <a href="#signup" class="bg-amber-500 px-6 py-3 rounded-full font-semibold hover:bg-amber-400 transition">
                Descargar libro
            </a>
        </div>
        <div>
            <img src="/images/book.png" alt="Libro" class="rounded-2xl shadow-2xl">
        </div>
    </div>
</section>

<!-- SINOPSIS -->
<section id="sinopsis" class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Sinopsis</h2>
        <p class="text-lg leading-relaxed text-gray-700">
            La historia que encierran estas páginas es una parte importante de la vida de la escritora, en la que los lectores pudieran encontrar alguna similitud con la suya, de no ser así, de cualquier manera le resultará muy interesante; lleva también el objetivo de dar a conocer como el amor de Jesucristo transformó una vida de mucho sufrimiento, de lucha incansable por salir adelante, de resistir los embates de la adversidad, de caminar con el peso de la derrota y las decepciones; de como un corazón roto y sin esperanza, al fortalecer la fe, en forma casi mágica e imperceptible, se fue transformando en algo muy difícil de explicar; pero que llena la mente, el cuerpo y el espíritu de esa paz que muchos buscan en los lugares equivocados.<br><br>
            Al menos por curiosidad, te recomendamos que lo leas y tal vez, sólo tal vez encuentrres lo mismo que la autora encontró y que le llevó hacia lo que siempre ha buscado el hombre, lo más parecido a la felicidad y que por experiencia te confirmamos que solamente encontrarás en Jesucristo.
            <br><br>
        </p>
    </div>
</section>

<!-- MENSAJE -->
<section id="mensaje" class="py-20">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Más que un libro</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
            Este no es solo un relato. Es una invitación. Un encuentro con la fe, con la resiliencia, y con una verdad que ha cambiado vidas.
            <br><br>
            La felicidad que tanto se busca no está donde todos miran… sino donde pocos se atreven a caminar.
        </p>
    </div>
</section>

<!-- FORM -->
<section id="signup" class="bg-gray-900 py-20 text-white">
    <div class="max-w-xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Obtén tu copia</h2>
        <p class="text-gray-300 mb-8">Déjanos tu correo y recibe el libro directamente.</p>

        <form method="POST" action="{{ route('subscribe') }}" class="space-y-4">
            @csrf
            <input type="email" name="email" required placeholder="Tu correo electrónico"
                   class="w-full px-4 py-3 rounded-lg text-gray-800">

            <button type="submit" class="w-full bg-amber-500 py-3 rounded-lg font-bold hover:bg-amber-400 transition">
                Descargar ahora
            </button>
        </form>
    </div>
</section>

<footer class="py-8 text-center text-sm text-gray-500">
    © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
</footer>

</body>
</html>

