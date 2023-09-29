let controlButtons = document.querySelectorAll('.csr-csr-control:not(#csr-show-controls)');

const map = window.map;

var newDrawStyle = {
    color: '#49138F'
};

for (let i = 0; i < controlButtons.length; i++) {
    controlButtons[i].addEventListener('click', function (e) {
        let controlButton = e.target.closest('.csr-csr-control');
        let activeControlButton = document.querySelector('.csr-csr-control-active');
        if (activeControlButton && activeControlButton !== controlButton) {
            map.pm.disableGlobalEditMode();
            map.pm.disableGlobalRemovalMode();
            map.pm.disableDraw();
            document.querySelector("#csr-add-polygon").dataset.addPolygon = "false";
            activeControlButton.classList.remove('csr-csr-control-active');
        }
        controlButton.classList.toggle('csr-csr-control-active');
    });
}

document.querySelector("#csr-show-controls").addEventListener("click", function (e) {
    for (let i = 0; i < controlButtons.length; i++) {
        setTimeout(() => {
            controlButtons[i].animate([
                { transform: 'translateY(0)' },
                { transform: `translateY(calc(-${100 * (i + 1)}% - ${(i + 1) * 0.5}rem))` },
            ], {
                duration: 500,
                easing: 'ease-in-out',
                fill: 'forwards',
            });
        }, 100 * (i + 1));
    }
});

document.querySelector("#csr-save-turf").addEventListener("click", async function (e) {
    let saveButton = e.target.closest("#csr-save-turf");
    let campaign_id = saveButton.dataset.campaignId;
    let csrf_token = saveButton.dataset.csrfToken;
    let turf = newDraws.toGeoJSON();
    let body = {
        geometry: turf,
        campaign_id: campaign_id,
    };
    let response = await fetch(`/${campaign_id}/turfs`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf_token,
        },
        body: JSON.stringify(body)
    });
    let data = await response.json();
    console.log(data);
    if (data.success) {
        window.location.reload();
    }
});

document.querySelector("#csr-add-polygon").addEventListener("click", function (e) {
    let addPolygonButton = e.target.closest("#csr-add-polygon");
    if (addPolygonButton.dataset.addPolygon === "true") {
        map.pm.disableDraw();
        addPolygonButton.dataset.addPolygon = "false";
    } else {
        map.pm.enableDraw("Polygon", {
            allowSelfIntersection: false,
        });
        addPolygonButton.dataset.addPolygon = "true";
    }

});

document.querySelector("#csr-edit-turf").addEventListener("click", function (e) {
    map.pm.toggleGlobalEditMode();
});

document.querySelector("#csr-search-zipcode").addEventListener("click", function (e) {
    document.querySelector("#csr-search-zipcode-blind").animate([
        { opacity: 0, visibility: 'hidden' },
        { opacity: 1, visibility: 'visible' },
    ], {
        duration: 500,
        easing: 'ease-in-out',
        fill: 'forwards',
    });
    document.querySelector("#csr-search-zipcode-form").querySelector("[name=zipcode]").focus();
});

document.querySelector("#csr-search-zipcode-close").addEventListener("click", function (e) {
    document.querySelector("#csr-search-zipcode-blind").animate([
        { opacity: 1, visibility: 'visible' },
        { opacity: 0, visibility: 'hidden' },
    ], {
        duration: 500,
        easing: 'ease-in-out',
        fill: 'forwards',
    });
    document.querySelector("#csr-search-zipcode").classList.remove('csr-csr-control-active');
});

document.querySelector("#csr-search-zipcode-form").addEventListener("submit", async function (e) {
    e.preventDefault();
    let form = e.target.closest("#csr-search-zipcode-form");
    let zipcode = form.querySelector("[name=zipcode]").value;
    let response = await fetch(`/api/zipcodes/${zipcode}`);
    let data = await response.json();
    if (data.length > 1) {
        alert("Multiple zipcodes found. Please try again.");
    } else if (data.length === 0) {
        alert("No zipcodes found. Please try again.");
    } else {
        let zipcodeShape = L.geoJSON(data[0].geoShape, {
            style: newDrawStyle,
        });
        window.newDraws.addLayer(zipcodeShape);
        map.fitBounds(zipcodeShape.getBounds());
        document.querySelector("#csr-search-zipcode-blind").animate([
            { opacity: 1, visibility: 'visible' },
            { opacity: 0, visibility: 'hidden' },
        ], {
            duration: 500,
            easing: 'ease-in-out',
            fill: 'forwards',
        });
        document.querySelector("#csr-search-zipcode").classList.remove('csr-csr-control-active');
        updateBuildingCount();
    }
});

document.querySelector("#csr-delete-turf").addEventListener("click", function (e) {
    map.pm.enableGlobalRemovalMode();
});


map.on('pm:create', function (e) {
    document.querySelector("#csr-add-polygon").dataset.addPolygon = "false";
    document.querySelector("#csr-add-polygon").classList.remove('csr-csr-control-active');
    updateBuildingCount();
});

map.on('pm:remove', function (e) {
    updateBuildingCount();
})
map.on("pm:globaleditmodetoggled", function (e) {
    updateBuildingCount();
});



document.querySelector("#csr-search-bar-form").addEventListener("submit", async function (e) {
    e.preventDefault();
    let form = e.target.closest("#csr-search-bar-form");
    let search = form.querySelector("[name=search]").value;
    let response = await fetch(`https://nominatim.openstreetmap.org/search?q=${search}&format=json`);
    let data = await response.json();
    map.flyTo([data[0].lat, data[0].lon], map.getZoom(), {
        duration: 1,
    });
});

window.addEventListener("keydown", function (e) {
    /* Check if Cmd/Control and K are pressed */
    if ((e.metaKey || e.ctrlKey) && e.key === "k") {
        document.querySelector("#csr-search-bar-form").querySelector("[name=search]").focus();
    }
});


const createLoader = () => {
    let loader = document.createElement("div");
    loader.classList.add("crs-form-loader");
    loader.innerHTML = `
  <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  `;
    document.body.appendChild(loader);
    setTimeout(() => {
        loader.style.opacity = 1;
    }, 100);
    return loader;
}

const removeLoader = (loader) => {
    loader.style.opacity = 0;
    setTimeout(() => {
        loader.remove();
    }, 500);
}

async function getBuildings() {
    let loader = createLoader();
    let turf = newDraws.toGeoJSON();
    let body = {
        turf: turf,
    };
    let response = await fetch(`/api/buildings/find`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body)
    });
    let data = await response.json();
    removeLoader(loader);
    return data;
}

async function updateBuildingCount() {
    console.log("Updating building count");
    let buildings = await getBuildings();
    if (!window.infoBox) {
        window.infoBox = document.createElement("div");
        window.infoBox.classList.add("csr-info-box");
        document.body.appendChild(window.infoBox);
    }
    window.infoBox.numberOfBuildings = buildings.number_of_buildings.toLocaleString("de-CH");
    window.infoBox.numberOfApartments = buildings.number_of_apartments.toLocaleString("de-CH");
    window.infoBox.innerHTML = `
    <div class="csr-info-box-inner">
        <p><b>Anzahl Gebäude:</b> ${window.infoBox.numberOfBuildings}</p>
        <p><b>Anzahl Wohnungen:</b> ${window.infoBox.numberOfApartments}</p>
    </div>`;
}
