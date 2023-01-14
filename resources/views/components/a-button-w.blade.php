<a {{ $attributes->merge(['type' => 'submit', 'href'=>'javascript:;', 'class' => 'inline-flex items-center content-center text-center px-1.5 md:px-4 py-2 bg-yellow-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
