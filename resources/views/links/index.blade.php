<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-2xl font-bold leading-tight text-[#25312d]">
                {{ __('My Links') }}
            </h2>
            <a href="{{ route('links.create') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-transparent bg-[#30483e] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-lg shadow-[#30483e]/15 transition hover:bg-[#253a32] focus:outline-none focus:ring-2 focus:ring-[#71866f] focus:ring-offset-2">
                <span class="text-lg leading-none">+</span> {{ __('Add Link') }}
            </a>
        </div>
    </x-slot>

    <div class="relative min-h-[calc(100vh-65px)] overflow-hidden px-5 py-10 sm:px-8 sm:py-14">
        <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#d8e4d5] opacity-70">
        </div>
        <div
            class="pointer-events-none absolute -bottom-40 -left-40 h-96 w-96 rounded-full border-[28px] border-[#ead7c4] opacity-70">
        </div>
        <div class="relative mx-auto max-w-3xl">
            @if (session('status'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm">
                {{ __(session('status')) }}
            </div>
            @endif

            <!-- Preview Link -->
            <div x-data="{ copied: false }" class="mb-8 rounded-2xl border border-[#cbd9c8] bg-[#e5eee1] p-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#9a6b4f]">{{ __('Share your page')
                        }}</p>
                    <p class="mt-1 text-sm text-[#53635b]">{{ __('Add this link to your social media bio so people can find everything you share.') }}</p>
                </div>
                <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                    <input type="text" readonly value="{{ $publicUrl }}" aria-label="{{ __('Your public page URL') }}"
                        class="min-w-0 flex-1 rounded-xl border border-[#cbd9c8] bg-white/80 px-4 py-3 text-sm text-[#30483e] shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]">
                    <button type="button"
                        @click="navigator.clipboard.writeText(@js($publicUrl)); copied = true; setTimeout(() => copied = false, 2000)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#30483e] px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white transition hover:bg-[#253a32] focus:outline-none focus:ring-2 focus:ring-[#71866f] focus:ring-offset-2">
                        <span x-text="copied ? '{{ __('Copied') }}' : '{{ __('Copy link') }}'"></span>
                    </button>
                    <a href="{{ $publicUrl }}" target="_blank"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#cbd9c8] bg-white px-4 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-[#30483e] transition hover:border-[#9cad96] hover:bg-[#edf1e9]">
                        {{ __('Preview') }} <span aria-hidden="true">↗</span>
                    </a>
                </div>
            </div>

            <div class="mb-8 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#9a6b4f]">{{ __('Link library') }}
                    </p>
                    <p class="mt-2 text-sm text-[#6b7770]">{{ __('Drag to arrange the order visitors will see.') }}</p>
                </div>
                <a href="{{ route('links.create') }}"
                    class="hidden rounded-xl border border-[#cbd9c8] bg-white px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.16em] text-[#30483e] transition hover:border-[#9cad96] hover:bg-[#edf1e9] sm:inline-flex">
                    <span class="mr-2 text-lg leading-none">+</span>{{ __('Add link') }}
                </a>
            </div>

            <!-- Reorder Form -->
            <form method="POST" action="{{ route('links.reorder') }}" id="reorder-form">
                @csrf
            </form>

            <div id="sortable-links" class="space-y-3">
                @forelse ($links as $link)
                <div class="group flex items-center gap-4 rounded-2xl border border-[#dfe4db] bg-white/90 p-4 shadow-[0_8px_24px_rgba(56,73,63,0.06)] transition hover:border-[#b8c9b4] hover:shadow-[0_12px_28px_rgba(56,73,63,0.10)]"
                    data-id="{{ $link->id }}">
                    <input type="hidden" name="ids[]" value="{{ $link->id }}" form="reorder-form">

                    <!-- Drag Handle -->
                    <div class="drag-handle cursor-grab text-[#a0aaa2] transition hover:text-[#30483e]"
                        title="{{ __('Drag to reorder') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </div>

                    <!-- Link Info -->
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            @if ($link->icon)
                            <span class="text-gray-500">{{ $link->icon }}</span>
                            @endif
                            <p class="truncate font-semibold text-[#25312d]">{{ $link->title }}</p>
                            @unless ($link->is_active)
                            <span
                                class="inline-flex items-center rounded-full bg-[#f3e5dc] px-2 py-0.5 text-xs font-medium text-[#9a6b4f]">
                                {{ __('Inactive') }}
                            </span>
                            @endunless
                        </div>
                        <p class="truncate text-sm text-[#829087]">{{ parse_url($link->url, PHP_URL_HOST) ?: $link->url
                            }}</p>
                        <p class="mt-1 text-xs text-[#9a6b4f]">{{ number_format($link->clicks) }} {{ __('clicks') }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Toggle Active -->
                        <form method="POST" action="{{ route('links.toggle', $link) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="{{ $link->is_active ? __('Deactivate') : __('Activate') }}"
                                class="rounded-xl p-2 {{ $link->is_active ? 'text-[#269c5a] hover:bg-[#edf7ef]' : 'text-[#a0aaa2] hover:bg-[#f3f5f2]' }}">
                                @if ($link->is_active)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @endif
                            </button>
                        </form>

                        <!-- Edit -->
                        <a href="{{ route('links.edit', $link) }}"
                            class="rounded-xl p-2 text-[#829087] hover:bg-[#edf1e9] hover:text-[#30483e]"
                            title="{{ __('Edit') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <!-- Delete -->
                        <form method="POST" action="{{ route('links.destroy', $link) }}"
                            onsubmit="return confirm('{{ __('Are you sure you want to delete this link?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-xl p-2 text-[#829087] hover:bg-[#f9ece7] hover:text-[#b85b4a]"
                                title="{{ __('Delete') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="rounded-2xl border border-dashed border-[#cbd5ca] bg-white/60 p-10 text-center">
                    <p class="font-serif text-xl font-semibold text-[#53635b]">{{ __('Your link library is ready.') }}
                    </p>
                    <p class="mt-2 text-sm text-[#829087]">{{ __('Add your first link to start building your page.') }}
                    </p>
                    <a href="{{ route('links.create') }}"
                        class="mt-5 inline-flex rounded-xl bg-[#30483e] px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.16em] text-white hover:bg-[#253a32]">
                        {{ __('Add your first link') }}
                    </a>
                </div>
                @endforelse
            </div>

            @if ($links->count() > 1)
            <div class="mt-4 flex justify-end">
                <x-primary-button form="reorder-form"
                    class="rounded-xl border-0 bg-[#30483e] px-5 py-3 text-xs tracking-[0.16em] shadow-lg shadow-[#30483e]/15 hover:bg-[#253a32]">
                    {{ __('Save Order') }}</x-primary-button>
            </div>
            @endif
        </div>
    </div>

    @if ($links->count() > 1)
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script>
        new Sortable(document.getElementById('sortable-links'), {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'opacity-50',
            });
    </script>
    @endif
</x-app-layout>