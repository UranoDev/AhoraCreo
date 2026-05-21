@props(['value'])

<label {{ $attributes->merge(['class' => 'block serif font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
