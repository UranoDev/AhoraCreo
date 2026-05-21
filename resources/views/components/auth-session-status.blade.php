@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-3 bg-green-50 border border-green-200 rounded-sm text-green-700 text-sm italic serif']) }}>
        {{ $status }}
    </div>
@endif
