<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyLinks') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-[#25312d]">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#f6f3ed] px-5 py-10 sm:px-8">
        <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#d8e4d5] opacity-70">
        </div>
        <div
            class="pointer-events-none absolute -bottom-40 -left-40 h-96 w-96 rounded-full border-[28px] border-[#ead7c4] opacity-70">
        </div>

        <div class="absolute top-5 ltr:right-5 rtl:left-5 z-20">
            <x-language-switcher />
        </div>

        <div class="relative w-full sm:max-w-lg">
            <div
                class="rounded-[2rem] border border-[#dfe4db] bg-white/90 p-6 shadow-[0_20px_60px_rgba(56,73,63,0.10)] backdrop-blur sm:p-10">
                {{ $slot }}
            </div>
            <p class="mt-6 text-center text-xs font-semibold uppercase tracking-[0.18em] text-[#829087]">{{ __('Share
                what matters.') }}</p>
        </div>
    </div>
</body>

</html>