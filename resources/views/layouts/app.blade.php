<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CWSMS - Robust school management system.">
    <meta name="author" content="Codewrite Technology Limited">
    <meta name="keywords"
        content="codewrite,school managment, school, academic system, school school system,managment system, online school">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::user()->api_token }}">

    <title>{{ config('app.name', 'SYMANUS') }}</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo.png') }} " />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Base Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Custom Styles -->
    @yield('style', '')

    <!-- Base Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Custom Scripts -->
    @yield('script', '')
</head>

<body class="font-sans antialiased box-border">
    <div class="min-h-screen bg-gray-50 dark:bg-slate-900">
        @include('layouts.header', ['appName' => $setting->getValue('app_name')])
        <div style="top: 64px"
            class="sticky inset-x-0 z-[40] bg-white border-y px-4 lg:pl-72 sm:px-6 md:px-8  dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between py-4">
                @yield('breadcrumb')
            </div>
        </div>
        @include('layouts.sidebar')
        
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>
</body>

</html>
