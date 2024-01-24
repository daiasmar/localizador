document.addEventListener("DOMContentLoaded", e => {
    let data = new FormData();
    data.append('action', 'localizador_ajax');

    fetch(admin_ajax.ajaxurl, {
        method: 'POST',
        body: data,
    })
        .then(response => response.json())
        .then(data => {

            console.log(data);
            const apiGoogle = data.api;

            window.initMap = async function () {
                const position = { lat: 40.4167754, lng: -3.7037902 };
                map = new google.maps.Map(document.getElementById("map-localizador"), {
                    zoom: 6.2,
                    center: position,
                });

                if (typeof getLocation === 'function') {
                    getLocation(data.locations);
                }
            }

            let script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiGoogle}&libraries=places&callback=initMap`;
            document.head.appendChild(script);
            script.setAttribute('async', '');
            script.setAttribute('defer', '');

        });
});

let map;
let markers = [];

function getLocation(localizaciones) {
    const localPointsContainer = document.getElementById('localPointsContainer');
    //NOTA: Este forEach crea los botones iterando por el objeto.
    localizaciones.forEach((value, index) => {
        const button = document.createElement('button');
        button.classList.add('button-points', 'dis-flex');

        const logoNut = '<div class="logo-nut"></div>';
        const nombre = `<p>${value.sede ? value.sede : 'Sede no disponible'}<p>`;
        const direccion = `<p>${value.calle ? value.calle : 'Dirección no disponible'}<p>`;
        const web = `<a href="${value.URL ? value.URL : '#'}" target="_blank">+ info</a>`;


        const buttonContent = logoNut + '<div class="box-text-1">' + nombre + direccion + '</div>' + '<div class="box-text-2">' + web + '</div>';
        button.innerHTML = buttonContent;

        localPointsContainer.appendChild(button);

        //NOTA: El icono del logo tenemos que enviarlo por url guardandolo en la tabla.
        const marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(parseFloat(value.coordenadas[0]), parseFloat(value.coordenadas[1])),
            title: value.sede,
            icon: {
                url: 'https://img.icons8.com/external-others-inmotus-design/67/external-Pointer-round-icons-others-inmotus-design-3.png',
                scaledSize: new google.maps.Size(30, 30)
            }
        });

        markers.push(marker);
        //NOTA: Recordar modificar el icono desla URL, el icono activo debe ser más grande.
        button.addEventListener('click', () => {
            document.querySelectorAll('.button-points').forEach((btn, idx) => {
                btn.classList.remove('active');
                const logoNut = btn.querySelector('.logo-nut');
                if (logoNut) {
                    logoNut.classList.remove('active');
                }
                markers[idx].setIcon({
                    url: 'https://img.icons8.com/external-others-inmotus-design/67/external-Pointer-round-icons-others-inmotus-design-3.png',
                    scaledSize: new google.maps.Size(30, 30)
                });
            });
            button.classList.add('active');
            const logoNut = button.querySelector('.logo-nut');
            if (logoNut) {
                logoNut.classList.add('active');
            }


            markers[index].setIcon({
                url: 'https://img.icons8.com/external-others-inmotus-design/67/external-Pointer-round-icons-others-inmotus-design-3.png',
                scaledSize: new google.maps.Size(45, 45)
            });

            map.setCenter(new google.maps.LatLng(parseFloat(value.coordenadas[0]), parseFloat(value.coordenadas[1])));
            map.setZoom(12);
        });
    });
}







