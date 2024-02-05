document.addEventListener("DOMContentLoaded", (e) => {
  let data = new FormData();
  data.append("action", "localizador_ajax");

  fetch(admin_ajax.ajaxurl, {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data.locations);
      const ciudadesDisponibles = Array.from(new Set(data.locations.map(location => location.ciudad)));

      console.log(data);
      const apiGoogle = data.api;

      window.initMap = async function () {
        const position = { lat: 40.4167754, lng: -3.7037902 };
        map = new google.maps.Map(document.getElementById("map-localizador"), {
          zoom: 6.2,
          center: position,
        });

        if (typeof getLocation === "function") {
          getLocation(data.locations, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.promotion.message, data.promotion.color, data.promotion.background, ciudadesDisponibles);
        }

        document
          .querySelector('.search-bar input[type="search"]')
          .addEventListener("input", function () {
            const terminoBusqueda = this.value.trim();

            const localizacionesFiltradas = filtrarLocalizaciones(
              data.locations,
              terminoBusqueda
            );
            limpiarMapaYContenedor();

            if (
              terminoBusqueda === "" ||
              localizacionesFiltradas.length === 0
            ) {

              const centroPredeterminado = {
                lat: 40.4167754,
                lng: -3.7037902,
              };
              const zoomPredeterminado = 6.2;
              map.panTo(centroPredeterminado);
              map.setZoom(zoomPredeterminado);
            } else if (localizacionesFiltradas.length > 0) {
              const centroMapa = {
                lat: parseFloat(localizacionesFiltradas[0].coordenadas[0]),
                lng: parseFloat(localizacionesFiltradas[0].coordenadas[1]),
              };
              map.panTo(centroMapa);
              map.setZoom(10);
            }

            getLocation(localizacionesFiltradas, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.promotion.message, data.promotion.color, data.promotion.background, ciudadesDisponibles);
          });
      };

      let script = document.createElement("script");
      script.src = `https://maps.googleapis.com/maps/api/js?key=${apiGoogle}&libraries=places&callback=initMap`;
      document.head.appendChild(script);
      script.setAttribute("async", "");
      script.setAttribute("defer", "");
    });
});

let map;
let markers = [];

function filtrarLocalizaciones(localizaciones, terminoBusqueda) {
  if (!terminoBusqueda) return localizaciones;
  return localizaciones.filter(
    (loc) =>
      loc.ciudad.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      (loc.cp && String(loc.cp).startsWith(terminoBusqueda))
  );
}

function limpiarMapaYContenedor() {
  document.getElementById("localPointsContainer").innerHTML = "";
  markers.forEach((marker) => marker.setMap(null));
  markers = [];
}

function getLocation(localizaciones, markerOnly, markerActive, logoOnly, logoActive, promoText, promotionColor, promotionBackground, ciudadesDisponibles) {

  // MENSAJE SI NO HAY RESULTADO.
  const imageUrl = 'http://localhost/nut/wp-content/uploads/2024/02/Recurso-3.png';

  if (localizaciones.length === 0) {
    const localPointsContainer = document.getElementById("localPointsContainer");
    const imageElement = document.createElement('img');
    imageElement.src = imageUrl;
    imageElement.className = 'imagen-lupa';
    imageElement.alt = 'Icono de no hay resultados';
    localPointsContainer.appendChild(imageElement);
    const paragraph = document.createElement('p');
    paragraph.className = 'no-result';
    paragraph.textContent = 'No hemos encontrado ningún trastero';
    localPointsContainer.appendChild(paragraph);
    console.log(ciudadesDisponibles, "////////");
  
    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'buttons-container';
  
    ciudadesDisponibles.forEach(ciudad => {
      const cityButton = document.createElement("button");
      cityButton.textContent = ciudad;
      cityButton.classList.add("city-button");
  
      cityButton.addEventListener('click', () => {
        const searchInput = document.querySelector('.search-bar input[type="search"]');
        searchInput.value = ciudad;
        searchInput.dispatchEvent(new Event('input'));
      });
  
      buttonsContainer.appendChild(cityButton);
    });
  
    localPointsContainer.appendChild(buttonsContainer);
  
    return;
  }
  
  //Orden de ciudad por alfabeto
  localizaciones.sort((a, b) => {
    if (a.ciudad < b.ciudad) return -1;
    if (a.ciudad > b.ciudad) return 1;

    // Si las ciudades son iguales, compara por sede
    return a.sede.localeCompare(b.sede);
  });

  const localPointsContainer = document.getElementById("localPointsContainer");

  localizaciones.forEach((value, index) => {
    const button = document.createElement("button");
    button.classList.add("button-points");

    button.addEventListener("click", () => {
      document
        .querySelectorAll(".button-points")
        .forEach((otherButton, otherIndex) => {
          otherButton.classList.remove("active");
          const otherLogoNut = otherButton.querySelector(
            ".logo-nut, .logo-nut2"
          );
          if (otherLogoNut) {
            otherLogoNut.src = logoOnly;
            otherLogoNut.classList.remove("logo-nut2");
            otherLogoNut.classList.add("logo-nut");
          }

          if (markers[otherIndex]) {
            markers[otherIndex].setIcon({
              url: markerOnly,
              scaledSize: new google.maps.Size(35, 45),
            });
          }
        });

      button.classList.add("active");
      const logoNut = button.querySelector(".logo-nut");
      if (logoNut) {
        logoNut.src =
          logoActive;
        logoNut.classList.remove("logo-nut");
        logoNut.classList.add("logo-nut2");
      }

      // Configura el icono del marcador para el botón actual
      if (markers[index]) {
        markers[index].setIcon({
          url: markerActive,
          scaledSize: new google.maps.Size(46, 60),
        });
      }

      // Centra el mapa en la ubicación del marcador
      map.panTo(
        new google.maps.LatLng(
          parseFloat(value.coordenadas[0]),
          parseFloat(value.coordenadas[1])
        )
      );
      map.setZoom(10);
    });

    const logoNut = `<img src="${logoOnly}" class="logo-nut">`;
    const nombre = `<p><b>${value.sede ? value.sede : "Sede no disponible"}</b><p>`;
    const direccion = `<p>${value.calle ? value.calle : "Dirección no disponible"
      }<p>`;
    const nombreCiudad = `<p>${value.ciudad}, ${value.cp}`;
    const web = `<a href="${value.URL ? value.URL : "#"
      }" target="_blank">+ info</a>`;
    const promo = value.promocion == 'on' ? promoText : "";
    const buttonContent = `
      <div class="sede-click">
          ${logoNut}
          <div class="box-text-1">
              ${nombre}
              ${direccion}
              ${nombreCiudad}  
          </div>  
      <div class="box-text-2">
          ${web}
      </div>
      </div>
      ${promo ? `<div class="promo-banner" style="background:${promotionBackground}; color:${promotionColor};">
      <div class="promo-content">${promo}</div>
      <div class="promo-content">${promo}</div>
      </div>` : ''}`;

    button.innerHTML = buttonContent;

    localPointsContainer.appendChild(button);

    const marker = new google.maps.Marker({
      map: map,
      position: new google.maps.LatLng(
        parseFloat(value.coordenadas[0]),
        parseFloat(value.coordenadas[1])
      ),
      title: value.sede,
      icon: {
        url: markerOnly,
        scaledSize: new google.maps.Size(35, 42),
      },
    });

    markers.push(marker);

  });
}
