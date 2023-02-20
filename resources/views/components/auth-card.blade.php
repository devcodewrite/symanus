<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
    <div>
        <p class="mt-5">{{ config('app.name') }} {{ config('app.version') }} &copy; {{ config('app.vyear') }} <a href="https://codewrite.org">Codewrite Technology Ltd</a>.</p>
    </div>
</div>
