<a {{ $attributes->merge(['type' => 'submit', 'href'=>'javascript:;', 'class' => 'inline-flex items-center content-center text-center px-1.5 md:px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-700 active:bg-sky-900 focus:outline-none focus:border-sky-900 focus:ring ring-sky-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
