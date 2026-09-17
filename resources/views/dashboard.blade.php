<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#9a6b4f]">{{ __('Creator overview') }}
                </p>
                <h2 class="mt-1 font-serif text-2xl font-bold leading-tight text-[#25312d]">{{ __('Welcome back, :name',
                    ['name' => $user->name]) }}</h2>
            </div>
            <a href="{{ route('links.create') }}"
                class="hidden rounded-xl bg-[#30483e] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-lg shadow-[#30483e]/15 transition hover:bg-[#253a32] sm:inline-flex">
                <span class="mr-2 text-lg leading-none">+</span>{{ __('Add link') }}
            </a>
        </div>
    </x-slot>

    <div class="relative min-h-[calc(100vh-65px)] overflow-hidden px-5 py-10 sm:px-8 sm:py-14">
        <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#d8e4d5] opacity-70">
        </div>
        <div
            class="pointer-events-none absolute -bottom-40 -left-40 h-96 w-96 rounded-full border-[28px] border-[#ead7c4] opacity-70">
        </div>

        <main class="relative mx-auto max-w-5xl">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm text-[#6b7770]">{{ __('A quick look at how your page is performing.') }}</p>
                </div>
                <a href="{{ route('profile.public', $user->username) }}" target="_blank"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#30483e] hover:text-[#9a6b4f]">
                    {{ __('View public page') }} <span aria-hidden="true">↗</span>
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div
                    class="rounded-2xl border border-[#dfe4db] bg-white/85 p-6 shadow-[0_8px_24px_rgba(56,73,63,0.06)]">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#829087]">{{ __('Page visits') }}
                    </p>
                    <p class="mt-4 font-serif text-4xl font-bold text-[#25312d]">{{ number_format($profileViews) }}</p>
                    <p class="mt-2 text-sm text-[#6b7770]">{{ __('People who opened your page') }}</p>
                </div>
                <div
                    class="rounded-2xl border border-[#dfe4db] bg-white/85 p-6 shadow-[0_8px_24px_rgba(56,73,63,0.06)]">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#829087]">{{ __('Link clicks') }}
                    </p>
                    <p class="mt-4 font-serif text-4xl font-bold text-[#25312d]">{{ number_format($totalClicks) }}</p>
                    <p class="mt-2 text-sm text-[#6b7770]">{{ __('Visits sent to your links') }}</p>
                </div>
                <div
                    class="rounded-2xl border border-[#dfe4db] bg-white/85 p-6 shadow-[0_8px_24px_rgba(56,73,63,0.06)]">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#829087]">{{ __('Published links')
                        }}</p>
                    <p class="mt-4 font-serif text-4xl font-bold text-[#25312d]">{{ $links->where('is_active',
                        true)->count() }}</p>
                    <p class="mt-2 text-sm text-[#6b7770]">{{ __('Links currently visible') }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1.25fr_0.75fr]">
                <section
                    class="rounded-2xl border border-[#dfe4db] bg-white/85 p-6 shadow-[0_8px_24px_rgba(56,73,63,0.06)]">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#9a6b4f]">{{ __('Your
                                links') }}</p>
                            <h3 class="mt-1 font-serif text-2xl font-bold text-[#25312d]">
                                {{ __('What is getting attention') }}</h3>
                        </div>
                        <a href="{{ route('links.index') }}"
                            class="text-sm font-semibold text-[#30483e] hover:text-[#9a6b4f]">{{ __('Manage') }} <span
                                aria-hidden="true" class="inline-block rtl:rotate-180">→</span></a>
                    </div>
                    <div class="mt-6 flex flex-col gap-3">
                        @forelse ($links->sortByDesc('clicks')->take(3) as $link)
                        <div class="flex items-center gap-4 rounded-xl border border-[#e8ece5] bg-[#f8faf6] px-4 py-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e5eee1] text-[#30483e]">{{
                                $link->icon ?: '↗' }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-semibold text-[#25312d]">{{ $link->title }}</p>
                                <p class="truncate text-xs text-[#829087]">{{ parse_url($link->url, PHP_URL_HOST) ?:
                                    $link->url }}</p>
                            </div>
                            <span class="shrink-0 text-sm font-semibold text-[#9a6b4f]">{{ number_format($link->clicks)
                                }} {{ __('clicks') }}</span>
                        </div>
                        @empty
                        <p class="py-6 text-sm text-[#6b7770]">{{ __('Add a link to start seeing performance here.') }}
                        </p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-[#cbd9c8] bg-[#e5eee1] p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#9a6b4f]">{{ __('Next move') }}
                    </p>
                    <h3 class="mt-2 font-serif text-2xl font-bold text-[#25312d]">{{ __('Keep your page fresh.') }}</h3>
                    <p class="mt-3 text-sm leading-6 text-[#53635b]">

                        {{ __('Add new destinations, reorder your best links, and share your page wherever your audience
                        already follows you.') }}
                    </p>
                    <a href="{{ route('links.create') }}"
                        class="mt-6 inline-flex rounded-xl bg-[#30483e] px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white transition hover:bg-[#253a32]">{{
                        __('Add another link') }}</a>
                </section>
            </div>
        </main>
    </div>
</x-app-layout>