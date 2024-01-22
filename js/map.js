document.addEventListener("DOMContentLoaded", e =>{
    let data = new FormData();
    data.append('action', 'localizador_ajax');

    fetch(admin_ajax.ajaxurl, {
        method : 'POST',
        body : data,
    })
    .then(response => response.json())
    .then(data => {

        console.log(data.locations);
        const apiGoogle = data.api;
    
        window.initMap = async function() {
            const position = { lat : 40.4167754, lng: -3.7037902 };
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
    script.setAttribute('async','');
    script.setAttribute('defer','');
        
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
        const web = `<a href="${value.URL ? value.URL : '#'}" target="_blank"><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="Ikon"><path class="planet-icon" d="m16 2a14 14 0 1 0 14 14 14.01572 14.01572 0 0 0 -14-14zm10.72528 8.64917c-1.67071-.17767-3.55872-.34564-5.62988-.46741a45.20707 45.20707 0 0 0 -1.60675-5.66089 12.0465 12.0465 0 0 1 7.23663 6.1283zm-11.91937-6.58868a11.90041 11.90041 0 0 1 2.38775 0 43.22726 43.22726 0 0 1 1.84327 6.017c-1.92408-.07843-3.96088-.10986-6.05762-.074a43.21535 43.21535 0 0 1 1.8266-5.943zm-2.29389.4602a45.23624 45.23624 0 0 0 -1.58129 5.54077c-1.83515.0716-3.70459.21863-5.57551.42084a12.04951 12.04951 0 0 1 7.15678-5.96161zm-8.017 8.09082c2.01928-.24927 4.0473-.43219 6.04681-.5177a35.96785 35.96785 0 0 0 -.44354 7.79053c-1.85572-.08893-3.73285-.26233-5.60242-.49249a11.94517 11.94517 0 0 1 -.00081-6.78034zm.86175 8.90943c1.64789.17761 3.29468.31329 4.9176.38854a28.82591 28.82591 0 0 0 1.12128 5.16877 12.06571 12.06571 0 0 1 -6.03884-5.55731zm12.88544 6.26129a11.78235 11.78235 0 0 1 -4.485-.00006 26.43908 26.43908 0 0 1 -1.4657-5.80146c.80182.01947 1.598.032 2.38086.032 1.7497 0 3.43891-.04761 5.05-.12311a26.44231 26.44231 0 0 1 -1.48012 5.89263zm1.66373-7.92723c-2.44213.12061-5.08.17487-7.80609.10529a33.9502 33.9502 0 0 1 .47028-7.92829c2.3891-.04883 4.707-.00683 6.87683.09156a33.972 33.972 0 0 1 .45898 7.73144zm.69825 7.22333a28.91873 28.91873 0 0 0 1.13543-5.29914c1.821-.11706 3.49048-.26794 4.985-.42694a12.06184 12.06184 0 0 1 -6.12043 5.72606zm1.30581-7.33828a35.947 35.947 0 0 0 -.431-7.50671c2.27839.14312 4.32026.3385 6.06672.53644a11.83545 11.83545 0 0 1 -.00049 6.46228c-1.63501.18518-3.53058.36816-5.63523.50799z" fill="#000000" style="fill: rgb(255, 255, 255);"></path></g></svg></a>`;


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
                markers[idx].setIcon({
                    url: 'https://img.icons8.com/external-others-inmotus-design/67/external-Pointer-round-icons-others-inmotus-design-3.png',
                    scaledSize: new google.maps.Size(30, 30)
                });
            });

            button.classList.add('active');
            markers[index].setIcon({
                url: 'https://img.icons8.com/external-others-inmotus-design/67/external-Pointer-round-icons-others-inmotus-design-3.png',
                scaledSize: new google.maps.Size(45, 45)
            });

            map.setCenter(new google.maps.LatLng(parseFloat(value.coordenadas[0]), parseFloat(value.coordenadas[1])));
            map.setZoom(12);
        });
    });
}







