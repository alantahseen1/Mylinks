<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#30483e]">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#30483e] font-serif text-lg text-[#f6f3ed]">M</span>
            {{ config('app.name', 'MyLinks') }}
        </a>
        <p class="mt-7 font-serif text-3xl font-bold leading-tight text-[#25312d]">Welcome back.</p>
        <p class="mt-2 text-sm leading-6 text-[#6b7770]">Pick up where you left off and keep sharing.</p>
    </div>

    <x-auth-session-status class="mb-5 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <x-input-label for="email" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                :value="__('Email')" />
            <x-text-input id="email"
                class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-3">
                <x-input-label for="password" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                    :value="__('Password')" />
                @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-[#9a6b4f] hover:text-[#30483e]"
                    href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                @endif
            </div>
            <x-text-input id="password"
                class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-[#6b7770]">
            <input id="remember_me" type="checkbox"
                class="rounded border-[#cbd5ca] text-[#30483e] shadow-sm focus:ring-[#71866f]" name="remember">
            <span>{{ __('Remember me') }}</span>
        </label>

        <div class="mt-2 flex flex-col gap-4">
            <x-primary-button
                class="w-full justify-center rounded-xl border-0 bg-[#30483e] py-3 text-xs tracking-[0.18em] shadow-lg shadow-[#30483e]/15 hover:bg-[#253a32] focus:bg-[#253a32] active:bg-[#1d3029]">
                {{ __('Log in to my page') }}
            </x-primary-button>
            <p class="text-center text-sm text-[#6b7770]">
                {{ __('New to MyLinks?') }}
                <a class="font-semibold text-[#9a6b4f] underline decoration-[#d9b9a1] underline-offset-4 hover:text-[#30483e]"
                    href="{{ route('register') }}">{{ __('Create your page') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>