<x-app-layout :title="__('Neue Kampagne erstellen')">
    <x-paper>
        <div class="max-w-xl">
            <header class="mb-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Erstelle eine neue Kampagne') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Fülle das folgende Formular aus, um eine neue Kampagne zu erstellen.') }}
                </p>
            </header>

            <form method="POST" action="{{route('campaigns.store')}}" class="space-y-6">
                @csrf
                <div class="csr-input-group">
                    <x-input-label for="title" :value="__('Kampagnen Name')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required/>
                    <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="description" :value="__('Beschreibung')" />
                    <x-textarea-input id="description" name="description" class="mt-1 block w-full" placeholder="optional"></x-textarea-input>
                    <x-input-error :messages="$errors->updatePassword->get('description')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="admins" :value="__('Admins')" />
                    <x-select-input id="admins" name="admins[]" :options="App\Models\User::all()->toArray()" :multiple="true" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("Bitte wähle mindestens eine*n Benutzer*in aus")}}</x-input-helper>
                    <x-input-error :messages="$errors->updatePassword->get('description')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Erstellen') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-paper>
</x-app-layout>
