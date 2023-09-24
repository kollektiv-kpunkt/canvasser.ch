<x-app-layout :title="__('Kampagnen')">
    <x-button-bar>
        <x-primary-nav-button :href="route('campaigns.create')">
            {{ __('Neue Kampagne') }}
        </x-primary-nav-button>
    </x-button-bar>
    @if ($campaigns->isEmpty())
        <x-paper>
            {{ __('Keine Kampagnen vorhanden.') }}
        </x-paper>
    @else
        <x-paper>
            <x-table>
                <x-table-head>
                    <th class="p-3 font-medium">{{__("Titel")}}</th>
                    <th class="p-3 font-medium">{{__("Beschreibung")}}</th>
                    <th class="p-3 font-medium">{{__("Aktionen")}}</th>
                </x-table-head>
                @foreach ($campaigns as $campaign)
                    <tr class="border border-secondary-50">
                        <td class="p-3 font-bold">{{$campaign->title}}</td>
                        <td class="p-3">{{$campaign->description}}</td>
                        <td class="p-3 flex justify-end gap-x-2">
                            <a href="{{route("campaigns.edit", $campaign->id)}}">
                                <span class="material-symbols-outlined text-secondary">edit</span>
                            </a>
                            <form method="POST" action="{{route("campaigns.destroy", $campaign->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="material-symbols-outlined text-red-500">delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-paper>
    @endif
</x-app-layout>
