
@props(['imgSize' => 'ms', 'setting'])

@php
    switch ($imgSize) {
        case 'xs':
            $imgClass = 'w-8';
            break;
        case 'ms':
            $imgClass = 'w-12';
            break;
        case 'ls':
            $imgClass = 'w-16';
            break;
        
        default:
            $imgClass = 'w-12';
            break;
    }
@endphp
<a class="flex-none text-xl font-semibold dark:text-white" href="#" aria-label="Logo">
    <img src="{{ $setting->getValue('org_logo_url') }}" alt="logo" class="{{ $imgClass }}">
    <span> {{ $setting->getValue('org_name') }} </span>
</a>