@props([
    'label' => '',
    'name',
    'type' => 'text',
    'value' => '',
    'note' => '',
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $type !== 'file' ? old($name, $value) : '' }}"
        {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}
    >

    @if ($note)
        <p class="text-xs text-red-500 mt-1">{{ $note }}</p>
    @endif
</div>
