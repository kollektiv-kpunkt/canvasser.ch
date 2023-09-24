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
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$campaign->title" required/>
                    <x-input-error :messages="$errors->updatePassword->get('title')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="description" :value="__('Beschreibung')" />
                    <x-textarea-input id="description" name="description" class="mt-1 block w-full" placeholder="optional">{{$campaign->description}}</x-textarea-input>
                    <x-input-error :messages="$errors->updatePassword->get('description')" class="mt-2" />
                </div>
                <div class="csr-input-group">
                    <x-input-label for="admins" :value="__('Admins')" />
                    <x-select-input id="admins" name="admins[]" :options="App\Models\User::all()->toArray()" :selected="$campaign->admins" :multiple="true" class="mt-1 block w-full" required />
                    <x-input-helper>{{__("Bitte wähle mindestens eine*n Benutzer*in aus")}}</x-input-helper>
                    <x-input-error :messages="$errors->updatePassword->get('description')" class="mt-2" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Speichern') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-paper>
</x-app-layout>
