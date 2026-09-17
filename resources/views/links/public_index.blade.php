<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


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
            <header class="mb-12 w-full max-w-xl">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.24em] text-[#9a6b4f]">{{ config('app.name',
                    'MyLinks') }} / {{ __('Explore') }}</p>
                <div class="flex items-end justify-between gap-6">
                    <h1 class="font-serif text-4xl font-bold leading-tight text-[#25312d] sm:text-5xl">{{ __('Discover
                        good links.') }}</h1>
                    <span
                        class="shrink-0 pb-1 text-right text-xs font-semibold uppercase tracking-[0.16em] text-[#6b7770]">{{
                        $links->count() }}<br>{{ Str::plural('link', $links->count()) }}</span>
                </div>
                <p class="mt-5 max-w-md text-base leading-7 text-[#53635b]">{{ __('A collection of things people are
                    sharing, making, and building.') }}</p>
            </header>

            <section aria-label="{{ __('Public links by user') }}" class="flex w-full flex-col gap-10">
                @forelse ($links->groupBy('user_id') as $userLinks)
                @php($user = $userLinks->first()->user)
                <article class="flex flex-col gap-4">
                    <header class="flex items-center gap-4">
                        @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                            class="h-14 w-14 rounded-2xl border-2 border-white object-cover shadow-md shadow-[#53665b]/15">
                        @else
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#30483e] shadow-md shadow-[#53665b]/20">
                            <span class="font-serif text-2xl font-bold text-[#f6f3ed]">{{ strtoupper(substr($user->name,
                                0, 1)) }}</span>
                        </div>
                        @endif
                        <div class="min-w-0">
                            <h2 class="truncate font-serif text-2xl font-bold text-[#25312d]">{{ $user->name }}</h2>
                            <p class="mt-1 truncate text-sm text-[#6b7770]">{{ '@' . $user->username }}</p>
                            @if ($user->bio)
                            <p class="mt-2 truncate text-sm text-[#53635b]">{{ $user->bio }}</p>
                            @endif
                        </div>
                    </header>
                    <div class="flex flex-col gap-3">
                        @foreach ($userLinks as $link)
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
                            <span class="min-w-0 flex-1 text-left">
                                <span class="block truncate font-semibold text-[#25312d]">{{ $link->title }}</span>
                                <span class="mt-1 block truncate text-xs text-[#829087]">{{ parse_url($link->url,
                                    PHP_URL_HOST)
                                    ?: $link->url }}</span>
                            </span>

                            <span aria-hidden="true"
                                class="text-xl text-[#9a6b4f] transition-transform group-hover:translate-x-1">→</span>
                        </a>
                        @endforeach
                    </div>
                </article>
                @empty
                <div class="rounded-2xl border border-dashed border-[#cbd5ca] bg-white/50 px-6 py-10 text-center">
                    <p class="font-serif text-xl font-semibold text-[#53635b]">{{ __('No public links yet.') }}</p>
                    <p class="mt-2 text-sm text-[#829087]">{{ __('Check back soon for something worth following.') }}
                    </p>
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