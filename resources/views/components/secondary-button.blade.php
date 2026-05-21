<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-3 bg-white border border-gray-200 rounded-sm font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#B8860B]/30 focus:ring-offset-2 disabled:opacity-25 transition duration-300']) }}>
    {{ $slot }}
</button>
