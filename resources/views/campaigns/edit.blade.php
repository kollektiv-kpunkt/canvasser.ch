<x-app-layout :title='__("Kampagne: {$campaign->title}")'>
    <x-paper>
        <div class="max-w-xl">
            <header class="mb-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Kampagne «{$campaign->title}» bearbeiten") }}
                </h2>
            </header>

            <form method="POST" action="{{route('campaigns.update', $campaign->id)}}" class="space-y-6">
                @csrf
                @method('put')
                <div class="csr-input-group">
                    <x-input-label for="title" :value="__('Kampagnen Name')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $campaign->title)" required/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="slug" :value="__('Kampagnen URL-Slug')" />
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $campaign->slug)" required/>
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="description" :value="__('Beschreibung')" />
                    <x-textarea-input id="description" name="description" class="mt-1 block w-full" placeholder="optional">{{old("description", $campaign->description)}}</x-textarea-input>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="region" :value="__('Region')" />
                    <x-select-input id="region" name="region" :options="['CH','AG','AI','AR','BE','BL','BS','FR','GE','GL','GR','JU','LU','NE','SG','SH','SO','SZ','TG','TI','UR','NW','OW','VD','VS','ZG','ZH']" :selected="[old('region', $campaign->region)] ?? []" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("In welcher Region willst du Flyer verteilen?")}}</x-input-helper>
                    <x-input-error :messages="$errors->get('region')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="admins" :value="__('Admins')" />
                    <x-select-input id="admins" name="admins[]" :options="App\Models\User::all()->toArray()" :selected="old('admins', $campaign->admins)" :multiple="true" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("Bitte wähle mindestens eine*n Benutzer*in aus")}}</x-input-helper>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Speichern') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-paper>
</x-app-layout>
