<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ku' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $user->name }} | {{ config('app.name', 'MyLinks') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:600,700&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f6f3ed] text-[#25312d]">
    <div class="relative min-h-screen overflow-hidden px-5 py-8 sm:px-8 sm:py-12">
        <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#d8e4d5] opacity-70">
        </div>
        <div
            class="pointer-events-none absolute -bottom-40 -left-40 h-96 w-96 rounded-full border-[28px] border-[#ead7c4] opacity-70">
        </div>

        <main class="relative mx-auto flex w-full max-w-2xl flex-col items-center">
            <div
                class="mb-10 flex w-full items-center justify-between text-xs font-semibold uppercase tracking-[0.22em] text-[#6b7770]">
                <span>{{ config('app.name', 'MyLinks') }}</span>
                <div class="flex items-center gap-3">
                    <span>{{ $links->count() }} {{ Str::plural('link', $links->count()) }}</span>
                    <x-language-switcher />
                </div>
            </div>

            @guest
            <a href="{{ route('register') }}"
                class="mb-10 flex w-full items-center justify-between gap-4 rounded-2xl border border-[#cbd9c8] bg-[#e5eee1] px-5 py-4 text-start transition hover:-translate-y-0.5 hover:border-[#9cad96] hover:bg-[#dce9d8] focus:outline-none focus:ring-2 focus:ring-[#30483e] focus:ring-offset-4 focus:ring-offset-[#f6f3ed]">
                <span>
                    <span class="block text-sm font-semibold text-[#30483e]">{{ __('Want a page like this?') }}</span>
                    <span class="mt-1 block text-xs text-[#53635b]">{{ __('Create your own links in minutes.') }}</span>
                </span>
                <span aria-hidden="true" class="shrink-0 text-xl text-[#9a6b4f] rtl:rotate-180">→</span>
            </a>
            @endguest

            <header class="mb-10 flex max-w-lg flex-col items-center text-center">
                @if ($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                    class="mb-5 h-28 w-28 rounded-[2rem] border-4 border-white object-cover shadow-xl shadow-[#53665b]/15">
                @else
                <div
                    class="mb-5 flex h-28 w-28 items-center justify-center rounded-[2rem] bg-[#30483e] shadow-xl shadow-[#53665b]/20">
                    <span class="font-serif text-4xl font-bold text-[#f6f3ed]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                @endif

                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.24em] text-[#9a6b4f]">{{ __('Welcome to my
                    corner') }}
                </p>
                <h1 class="font-serif text-4xl font-bold leading-tight text-[#25312d] sm:text-5xl">{{ $user->name }}
                </h1>
                <p class="mt-3 text-sm font-medium text-[#6b7770]">{{ '@' . $user->username }}</p>

                @if ($user->bio)
                <p class="mt-5 max-w-md text-base leading-7 text-[#53635b]">{{ $user->bio }}</p>
                @endif
            </header>

            <section aria-label="{{ __('Public links') }}" class="flex w-full flex-col gap-4">
                @forelse ($links as $link)
                <a href="{{ route('links.click', $link) }}" target="_blank" rel="noopener noreferrer"
                    class="group flex min-h-[76px] w-full items-center gap-4 rounded-2xl border border-[#dfe4db] bg-white/85 px-5 py-4 shadow-[0_8px_24px_rgba(56,73,63,0.06)] backdrop-blur transition duration-200 hover:-translate-y-1 hover:border-[#9cad96] hover:shadow-[0_14px_30px_rgba(56,73,63,0.12)] focus:outline-none focus:ring-2 focus:ring-[#30483e] focus:ring-offset-4 focus:ring-offset-[#f6f3ed]">
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#edf1e9] text-lg text-[#30483e] transition-colors group-hover:bg-[#30483e] group-hover:text-white">
                        @if ($link->icon)
                        {{ $link->icon }}
                        @else
                        <span aria-hidden="true">↗</span>
                        @endif
                    </span>
                    <span class="min-w-0 flex-1 text-start">
                        <span class="block truncate font-semibold text-[#25312d]">{{ $link->title }}</span>
                        <span class="mt-1 block truncate text-xs text-[#829087]">{{ parse_url($link->url, PHP_URL_HOST)
                            ?: $link->url }}</span>
                    </span>
                    <span aria-hidden="true"
                        class="text-xl text-[#9a6b4f] transition-transform ltr:group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1">→</span>
                </a>
                @empty
                <div class="rounded-2xl border border-dashed border-[#cbd5ca] bg-white/50 px-6 py-10 text-center">
                    <p class="font-serif text-xl font-semibold text-[#53635b]">{{ __('No links yet.') }}</p>
                    <p class="mt-2 text-sm text-[#829087]">{{ __('Check back soon for updates.') }}</p>
                </div>
                @endforelse
            </section>

            <footer
                class="mt-12 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#829087]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#9a6b4f]"></span>
                <a href="{{ url('/') }}" class="transition-colors hover:text-[#30483e]">{{ __('Made with :app', ['app'
                    => config('app.name', 'MyLinks')]) }}</a>
            </footer>
        </main>
    </div>
</body>

</html>