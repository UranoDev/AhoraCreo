<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-3 btn-gold border border-transparent rounded-sm font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-[#B8860B]/30 focus:ring-offset-2 transition duration-300']) }}>
    {{ $slot }}
</button>
