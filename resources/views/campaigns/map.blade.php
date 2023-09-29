@php
    $bounds = [
        "CH" => [[47.8308275417, 10.4427014502], [45.7769477403, 6.02260949059]],
        "AG" => [[47.6211124,8.4550999],[47.1374801,7.7134685]],
        "AR" => [[47.4690487,9.6309631],[47.2470247,9.1910895]],
        "AI" => [[47.4436942,9.6183988],[47.2339966,9.3097134]],
        "BL" => [[47.5643693,7.9618317],[47.3378823,7.3252806]],
        "BS" => [[47.6009125,7.6937903],[47.519294,7.5546608]],
        "BE" => [[47.3453097,8.4551574],[46.3265189,6.8614832]],
        "FR" => [[47.0068036,7.3802681],[46.437907,6.7423106]],
        "GE" => [[46.231885,6.1758527],[46.1777724,6.1102411]],
        "GL" => [[47.1739901,9.2525772],[46.796471,8.8712284]],
        "GR" => [[47.0651482,10.4922941],[46.1691798,8.6510632]],
        "JU" => [[47.3927751,7.9706175],[47.3926751,7.9705175]],
        "LU" => [[47.2871939,8.5140537],[46.7749903,7.8364131]],
        "NE" => [[47.063822,6.9917755],[46.977838,6.8451454]],
        "NW" => [[47.0199551,8.5749457],[46.7715167,8.2180924]],
        "OW" => [[46.9804532,8.5068781],[46.7531719,8.0421959]],
        "SH" => [[47.8084597,8.8762154],[47.5523654,8.404648]],
        "SZ" => [[47.2225672,9.0047149],[46.885294,8.3887412]],
        "SO" => [[47.5026958,8.0313669],[47.074342,7.3404127]],
        "SG" => [[47.5472144,9.6741357],[46.8728865,8.7956118]],
        "TI" => [[46.4772143,8.3876145],[46.4771143,8.3875145]],
        "TG" => [[47.6954269,9.502768],[47.375917,8.6679731]],
        "UR" => [[46.9934091,8.9578008],[46.5276306,8.3973573]],
        "VD" => [[47.3494394,7.9037193],[47.3493394,7.9036193]],
        "VS" => [[46.6540503,8.4785622],[45.8583145,6.7706262]],
        "ZG" => [[47.2483758,8.7011586],[47.0810323,8.3948352]],
        "ZH" => [[47.6944722,8.9849407],[47.1594376,8.3576804]]
    ]
@endphp
<x-frontend :title="$campaign->title">
    <x-application-logo class="w-16 fixed top-4 right-4 z-[10000]"/>
    <div class="w-screen h-screen" id="csr-map"></div>
    <div class="csr-search-bar flex w-full justify-center fixed top-4 z-[10000]">
        <form action="#" id="csr-search-bar-form" class="flex gap-4">
            <input type="search" name="search" class="w-72 md:w-96 rounded-full border-none" placeholder="{{__("Suchen (⌘/CTRL+K)")}}" required>
            <button type="submit" class="csr-search-button p-2 bg-accent rounded-full flex"><span class="material-symbols-outlined text-white">search</span></button>
        </form>
    </div>
    @if ((Auth::check() && Auth::user()->hasVerifiedEmail()) )
        <a href="#" id="csr-save-turf" class="csr-csr-control" data-campaign-id="{{$campaign->id}}" data-csrf-token="{{csrf_token()}}"><span class="material-symbols-outlined">save</span></a>
        <a href="#" id="csr-delete-turf" class="csr-csr-control"><span class="material-symbols-outlined">delete</span></a>
        <a href="#" id="csr-edit-turf" class="csr-csr-control"><span class="material-symbols-outlined">edit</span></a>
        <a href="#" id="csr-search-zipcode" class="csr-csr-control"><span class="material-symbols-outlined">search</span></a>
        <div id="csr-search-zipcode-blind" class="fixed bg-black top-0 left-0 w-screen h-screen z-[10005] bg-opacity-50 flex justify-center items-center opacity-0 invisible">
            <div class="csr-search-zipcode-wrapper w-full max-w-lg px-8 mx-auto">
                <div class="flex mb-4">
                    <span class="material-symbols-outlined ml-auto text-white cursor-pointer" id="csr-search-zipcode-close">close</span>
                </div>
                <form action="#" class="flex gap-4" id="csr-search-zipcode-form">
                    <input type="search" name="zipcode" id="csr-search-zipcode-input" class="rounded-full border-none w-full" placeholder="{{_("PLZ suchen")}}" required>
                    <button type="submit" class="csr-search-button p-2 bg-accent rounded-full flex"><span class="material-symbols-outlined text-white">search</span></button>
                </form>
            </div>
        </div>
        <a href="#" id="csr-add-polygon" class="csr-csr-control"><span class="material-symbols-outlined">stylus_note</span></a>
        <a href="#" id="csr-show-controls" class="csr-csr-control !z-[10001] !bg-accent !text-white"><span class="material-symbols-outlined !text-4xl">add</span></a>
    @else
        <a href="/{{$campaign->slug}}/edit" id="csr-login-turf" class="cursor-pointer bg-accent text-white flex gap-x-3 justify-center items-center rounded-md text-xl fixed bottom-8 left-8 z-[10000] p-3">Login <span class="material-symbols-outlined">login</span></a>
    @endif
</x-frontend>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css"/>
<script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>

<script>
    var map = L.map('csr-map');
    window.map = map;
    if (localStorage.getItem('csr-map-bounds|{{$campaign->slug}}')) {
        let bounds = JSON.parse(localStorage.getItem('csr-map-bounds|{{$campaign->slug}}'));
        map.fitBounds([ bounds._southWest,bounds._northEast]);
    } else {
        map.fitBounds({!! json_encode($bounds[$campaign->region]) !!});
    }
    var Stadia_AlidadeSmooth = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
        minZoom: 0,
        maxZoom: 20,
        attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ext: 'png'
    });
    Stadia_AlidadeSmooth.addTo(map);

    const newDraws = L.featureGroup().addTo(map);
    window.newDraws = newDraws;

    map.pm.setGlobalOptions({
        layerGroup: newDraws,
        pathOptions: {
            color: '#49138F'
        }
    });

    let existingTurfs = new L.featureGroup();
    let turf;
    var existingTurfStyle = { // Define your style object
        "color": "#FF5B51"
    };
    @foreach ($campaign->turfs as $turf)
        turf = L.geoJSON({!! json_encode($turf->geometry) !!}, {pmIgnore: true, style: existingTurfStyle });
        existingTurfs.addLayer(turf);
    @endforeach
    existingTurfs.addTo(map);

    map.on('moveend', function(e) {
        var bounds = map.getBounds();
        localStorage.setItem('csr-map-bounds|{{$campaign->slug}}', JSON.stringify(bounds));
    });
</script>
@vite(["resources/js/campaigns/map.js"])

