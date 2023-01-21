@props(['icon' => '', 'url' => 'javascript:;', 'title', 'uri' => null])
@php
$active = false;
$matches = false;

if($uri){
    $active = url()->current()=== $url;
    $uri = url($uri);
    $matches = $uri?Str::of(url()->current())->is("$uri*"):false;
}
@endphp
@if (!empty(trim($slot)))
    <li class="hs-accordion {{ $matches?'active':'' }}">
        <a
            {{ $attributes->merge(['href' => 'javascript:;', 'class' => 'hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white']) }}>
            {{ $icon }}
            {{ $title }}

            <svg class="hs-accordion-active:block ml-auto w-3 h-3 hidden text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>

            <svg class="hs-accordion-active:hidden ml-auto w-3 h-3 block text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
        </a>

        <div id="users-accordion-child"
            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300  {{$matches ?'block':'hidden'}}">
            <ul class="hs-accordion-group pl-3 pt-2" data-hs-accordion-always-open>
                {{ $slot }}
            </ul>
        </div>
    </li>
@else
    <li>
        <a
            {{ $attributes->merge(['href' => $url, 'class' => 'flex items-center gap-x-3.5 py-2 px-2.5 ' . ($active ? 'bg-gray-100' : '') . ' text-sm text-slate-700 rounded-md hover:bg-gray-100 dark:bg-gray-900 dark:text-white']) }}>
            {{ $icon }}
            {{ $title }}
        </a>
    </li>
@endif
