let controlButtons = document.querySelectorAll('.csr-csr-control:not(#csr-show-controls)');

const map = window.map;

document.querySelector("#csr-show-controls").addEventListener("click", function (e) {
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
        map.pm.enableDraw("Polygon");
        addPolygonButton.dataset.addPolygon = "true";
    }

});

document.querySelector("#csr-edit-turf").addEventListener("click", function (e) {
    map.pm.toggleGlobalEditMode();
});

document.querySelector("#csr-delete-turf").addEventListener("click", function (e) {
    map.pm.enableGlobalRemovalMode();
});
