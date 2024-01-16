document.addEventListener("DOMContentLoaded", e =>{
    let data = new FormData();
    data.append('action', 'localizador_ajax');

    fetch(admin_ajax.ajaxurl, {
        method : 'POST',
        body : data,
    })
    .then(response => response.json())
    .then(data => {
        const apiGoogle = data.api;

        let script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiGoogle}&libraries=places`;
        document.head.appendChild(script);
        script.setAttribute('async','');

        let scriptInit = document.createElement('script');
        scriptInit.src = `https://maps.googleapis.com/maps/api/js?key=${apiGoogle}&callback=initMap`;
        document.body.appendChild(scriptInit);
        scriptInit.setAttribute('async','');
        scriptInit.setAttribute('defer','');
    })
});

async function initMap(){

    const map = new google.maps.Map(document.getElementById('map-localizador'), {
        center : {
            lat : 40.4167754,
            lng: -3.7037902
        },
        zoom : 6
    });
    
}