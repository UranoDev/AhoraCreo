@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 rounded-sm shadow-sm text-gray-800 placeholder-gray-400 focus:border-transparent focus:outline-none focus:ring-1 focus:ring-gray-400']) }}>
