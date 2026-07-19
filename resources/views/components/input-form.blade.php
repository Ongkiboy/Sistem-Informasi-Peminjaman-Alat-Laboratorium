@props([
    'label',
    'nama',
    'tipe' => 'text',
    'wajib' => false,
    'bantuan' => null,
])

<div class="mb-4">
    <label for="{{ $nama }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($wajib)<span class="text-red-500">*</span>@endif
    </label>

    @if($tipe === 'textarea')
        <textarea name="{{ $nama }}" id="{{ $nama }}"
                  {{ $attributes->except('value')->class([
                      'w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200',
                      'border-gray-300' => !$errors->has($nama),
                      'border-red-500 focus:ring-red-500' => $errors->has($nama),
                  ]) }}>{{ old($nama, $attributes->get('value')) }}</textarea>
    @elseif($tipe === 'select')
        <select name="{{ $nama }}" id="{{ $nama }}"
                {{ $attributes->except(['value', 'options'])->class([
                    'w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200',
                    'border-gray-300' => !$errors->has($nama),
                    'border-red-500 focus:ring-red-500' => $errors->has($nama),
                ]) }}>
            {{ $slot }}
        </select>
    @else
        <input type="{{ $tipe }}" name="{{ $nama }}" id="{{ $nama }}"
               value="{{ old($nama, $attributes->get('value')) }}"
               {{ $attributes->except('value')->class([
                   'w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200',
                   'border-gray-300' => !$errors->has($nama),
                   'border-red-500 focus:ring-red-500' => $errors->has($nama),
               ]) }}>
    @endif

    @if($bantuan && !$errors->has($nama))
        <p class="text-xs text-gray-500 mt-1">{{ $bantuan }}</p>
    @endif

    @error($nama)
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
