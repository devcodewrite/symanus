
@props(['imgSize' => 'ms', 'appName' => '', 'textAlign' => 'items-end'])

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
            case 'xls':
            $imgClass = 'w-18';
            break;
        
        default:
            $imgClass = 'w-12';
            break;
    }
@endphp
<a class="flex {{ $textAlign }} text-xl font-semibold dark:text-white" href="{{url('dashboard')}} " aria-label="Logo">
    <img src="{{ asset('img/logo.png') }}" alt="logo" class="{{ $imgClass }}">
    <span class="uppercase sm:hidden lg:inline"> {{ $appName }} </span>
</a>