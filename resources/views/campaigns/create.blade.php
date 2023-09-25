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
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="slug" :value="__('Kampagnen URL-Slug')" />
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required/>
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="description" :value="__('Beschreibung')" />
                    <x-textarea-input id="description" name="description" class="mt-1 block w-full" placeholder="optional">{{old("description")}}</x-textarea-input>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="region" :value="__('Region')" />
                    <x-select-input id="region" name="region" :options="['CH','AG','AI','AR','BE','BL','BS','FR','GE','GL','GR','JU','LU','NE','SG','SH','SO','SZ','TG','TI','UR','NW','OW','VD','VS','ZG','ZH']" :selected="[old('region')] ?? []" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("In welcher Region willst du Flyer verteilen?")}}</x-input-helper>
                    <x-input-error :messages="$errors->get('region')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="admins" :value="__('Admins')" />
                    <x-select-input id="admins" name="admins[]" :options="App\Models\User::all()->toArray()" :selected="old('admins') ?? []" :multiple="true" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("Bitte wähle mindestens eine*n Benutzer*in aus")}}</x-input-helper>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Erstellen') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-paper>
</x-app-layout>

<script>
    document.querySelector("input#title").addEventListener("input", function(e) {
        document.querySelector("input#slug").value = e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/(^-|-$)/g, "");
    });
</script>
