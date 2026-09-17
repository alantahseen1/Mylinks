<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('links.update', $link) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            :value="old('title', $link->title)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="url" :value="__('URL')" />
                        <x-text-input id="url" name="url" type="url" class="mt-1 block w-full"
                            :value="old('url', $link->url)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('url')" />
                    </div>

                    <div>
                        <x-input-label for="icon" :value="__('Icon (optional)')" />
                        <x-text-input id="icon" name="icon" type="text" class="mt-1 block w-full"
                            :value="old('icon', $link->icon)" placeholder="{{ __('e.g. 🔗 or an emoji') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('icon')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update Link') }}</x-primary-button>
                        <a href="{{ route('links.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 underline">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>