<x-guest-layout>
    <div class="mb-8 text-center">
        <a href="{{ url('/') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#30483e]">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#30483e] font-serif text-lg text-[#f6f3ed]">M</span>
            {{ config('app.name', 'MyLinks') }}
        </a>
        <p class="mt-7 font-serif text-3xl font-bold leading-tight text-[#25312d]">Your links, in one place.</p>
        <p class="mt-2 text-sm leading-6 text-[#6b7770]">Create your public page and start sharing what matters.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <x-input-label for="username" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                :value="__('Choose your handle')" />
            <div
                class="mt-2 flex items-center rounded-xl border border-[#dfe4db] bg-[#f8faf6] px-4 transition focus-within:border-[#71866f] focus-within:ring-2 focus-within:ring-[#d8e4d5]">
                <span class="text-sm text-[#829087]">mylinks.com/</span>
                <x-text-input id="username"
                    class="block w-full border-0 bg-transparent px-0 py-3 text-[#25312d] shadow-none focus:ring-0"
                    type="text" name="username" :value="old('username')" required autofocus autocomplete="username"
                    placeholder="your-handle" />
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="name" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                    :value="__('Name')" />
                <x-text-input id="name"
                    class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                    type="text" name="name" :value="old('name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                    :value="__('Email')" />
                <x-text-input id="email"
                    class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="password" class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                    :value="__('Password')" />
                <x-text-input id="password"
                    class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation"
                    class="text-xs font-semibold uppercase tracking-[0.16em] text-[#53635b]"
                    :value="__('Confirm password')" />
                <x-text-input id="password_confirmation"
                    class="mt-2 block w-full rounded-xl border-[#dfe4db] bg-[#f8faf6] px-4 py-3 shadow-none focus:border-[#71866f] focus:ring-[#d8e4d5]"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-2 flex flex-col gap-4">
            <x-primary-button
                class="w-full justify-center rounded-xl border-0 bg-[#30483e] py-3 text-xs tracking-[0.18em] shadow-lg shadow-[#30483e]/15 hover:bg-[#253a32] focus:bg-[#253a32] active:bg-[#1d3029]">
                {{ __('Create my page') }}
            </x-primary-button>
            <p class="text-center text-sm text-[#6b7770]">
                {{ __('Already have a page?') }}
                <a class="font-semibold text-[#9a6b4f] underline decoration-[#d9b9a1] underline-offset-4 hover:text-[#30483e]"
                    href="{{ route('login') }}">{{ __('Log in') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>