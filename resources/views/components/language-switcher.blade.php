@props(['align' => 'right', 'width' => '36'])

@php
$currentLocale = app()->getLocale();
$languages = [
'en' => ['name' => 'English', 'native' => 'English'],
'ku' => ['name' => 'Kurdish', 'native' => 'کوردی'],
];
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <button type="button" @click="open = ! open"
        class="inline-flex items-center gap-1.5 rounded-xl border border-[#cbd9c8] bg-white/90 px-3 py-1.5 text-xs font-semibold text-[#30483e] shadow-sm transition hover:border-[#9cad96] hover:bg-[#edf1e9] focus:outline-none focus:ring-2 focus:ring-[#71866f] focus:ring-offset-2">
        <svg class="h-4 w-4 text-[#829087]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
        </svg>
        <span>{{ $languages[$currentLocale]['native'] ?? 'Language' }}</span>
        <svg class="h-3.5 w-3.5 text-[#829087]" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 w-36 rounded-xl border border-[#dfe4db] bg-white p-1 shadow-lg ltr:right-0 rtl:left-0"
        style="display: none;" @click="open = false">
        @foreach ($languages as $code => $lang)
        <a href="{{ route('locale.switch', $code) }}"
            class="flex items-center justify-between rounded-lg px-3 py-2 text-xs font-medium transition hover:bg-[#edf1e9] {{ $currentLocale === $code ? 'bg-[#e5eee1] font-bold text-[#30483e]' : 'text-[#53635b]' }}">
            <span>{{ $lang['native'] }}</span>
            @if ($currentLocale === $code)
            <svg class="h-3.5 w-3.5 text-[#30483e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
            @endif
        </a>
        @endforeach
    </div>
</div>