document.addEventListener("DOMContentLoaded", (e) => {
  let data = new FormData();
  data.append("action", "localizador_ajax");

  fetch(admin_ajax.ajaxurl, {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const provinciasDisponibles = Array.from(new Set(data.locations.map(location => location.provincia)));

      console.log(data);
      const apiGoogle = data.api;

      window.initMap = async function () {
        const position = { lat: 40.4167754, lng: -3.7037902 };
        map = new google.maps.Map(document.getElementById("map-localizador"), {
          zoom: 6.2,
          center: position,
        });

        if (typeof getLocation === "function") {
          getLocation(data.locations, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.media.not_found, data.promotion.message, data.promotion.color, data.promotion.background, data.promotion.effect, provinciasDisponibles);
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

            getLocation(localizacionesFiltradas, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.media.not_found, data.promotion.message, data.promotion.color, data.promotion.background, data.promotion.effect, provinciasDisponibles);
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
      loc.provincia.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      loc.poblacion.toLowerCase().includes(terminoBusqueda.toLowerCase()) ||
      (loc.cp && String(loc.cp).startsWith(terminoBusqueda))
  );
}

function limpiarMapaYContenedor() {
  document.getElementById("localPointsContainer").innerHTML = "";
  markers.forEach((marker) => marker.setMap(null));
  markers = [];
}

function getLocation(localizaciones, markerOnly, markerActive, logoOnly, logoActive, notFound, promoText, promotionColor, promotionBackground, promotionEffect, provinciasDisponibles) {

  // MENSAJE SI NO HAY RESULTADO.
  const imageUrl = notFound;

  if (localizaciones.length === 0) {
    const localPointsContainer = document.getElementById("localPointsContainer");
  
    const imageElement = document.createElement('img');
    imageElement.src = imageUrl;
    imageElement.className = 'imagen-lupa';
    imageElement.alt = 'Icono de no hay resultados';
    localPointsContainer.appendChild(imageElement);

    const paragraph = document.createElement('p');
    paragraph.className = 'no-result';
    const searchInput = document.querySelector('.search-bar input[type="search"]');
    const valorBusqueda = searchInput.value;
    paragraph.textContent = 'No hemos encontrado ningún trastero por tu búsqueda: ' + valorBusqueda;  
    localPointsContainer.appendChild(paragraph);

    const customSelectWrapper = document.createElement('div');
    customSelectWrapper.className = 'custom-select-wrapper';

    const customSelect = document.createElement('div');
    customSelect.className = 'custom-select';

    const customSelectTrigger = document.createElement('div');
    customSelectTrigger.setAttribute('tabindex', '0');
    customSelectTrigger.className = 'custom-select__trigger';
    customSelectTrigger.innerHTML = '<span>Ver trasteros por provincias</span><div class="arrow"></div>';
    
    const customOptions = document.createElement('div');
    customOptions.className = 'custom-options';

    provinciasDisponibles.forEach(ciudad => {
        const customOption = document.createElement('span');
        customOption.className = 'custom-option';
        customOption.setAttribute('data-value', ciudad);
        customOption.textContent = ciudad;

        customOption.addEventListener('click', function() {
            document.querySelector('.custom-select__trigger span').textContent = this.textContent;
            customSelect.classList.remove('open');
            const searchInput = document.querySelector('.search-bar input[type="search"]');
            searchInput.value = this.getAttribute('data-value');
            searchInput.dispatchEvent(new Event('input'));
        });

        customOptions.appendChild(customOption);
    });

    customSelect.appendChild(customSelectTrigger);
    customSelect.appendChild(customOptions);
    customSelectWrapper.appendChild(customSelect);
    localPointsContainer.appendChild(customSelectWrapper);

    customSelectTrigger.addEventListener('click', () => {
        customSelect.classList.toggle('open');
    });

    window.addEventListener('click', (e) => {
        if (!customSelect.contains(e.target)) {
            customSelect.classList.remove('open');
        }
    });
  }

  //Orden de ciudad por alfabeto
  localizaciones.sort((a, b) => {
    if (a.provincia < b.provincia) return -1;
    if (a.provincia > b.provincia) return 1;

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

      if (markers[index]) {
        markers[index].setIcon({
          url: markerActive,
          scaledSize: new google.maps.Size(46, 60),
        });
      }

      map.panTo(
        new google.maps.LatLng(
          parseFloat(value.coordenadas[0]),
          parseFloat(value.coordenadas[1])
        )
      );
      map.setZoom(10);
    });

    const logoNut = `<img src="${logoOnly}" class="logo-nut">`;
    const nombre = `<p><b>${value.sede ? value.sede : "Sede no disponible"}</b></p>`;
    const direccion = `<p>${value.calle ? value.calle : "Dirección no disponible"
      }</p>`;
    const nombreCiudad = `<p>${value.cp}, ${value.poblacion}, ${value.provincia}</p>`;
    const web = `<a href="${value.URL ? value.URL : "#"
      }" target="_blank">+ info</a>`;
    const promo = value.promocion == 'on' ? promoText : "";

    let divContent;
      if (promo && promotionEffect !== "1") {
        divContent = `<div class="otro-div" style="background:${promotionBackground}; color:${promotionColor};">
        <div class="no-effect">${promo}</div>
        </div>`;
      } else if (promo) {
        divContent = `<div class="promo-banner" style="background:${promotionBackground}; color:${promotionColor};">
        <div class="promo-content">${promo}</div>
        <div class="promo-content">${promo}</div>
        </div>`;
      } else {
        divContent = '';
      }

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
      ${divContent}`;

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

    marker.addListener("click", () => {
      document.querySelectorAll(".button-points").forEach((otherButton, otherIndex) => {
        otherButton.classList.remove("active");
        const otherLogoNut = otherButton.querySelector(".logo-nut, .logo-nut2");
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
  
      const button = document.querySelectorAll(".button-points")[index];
      button.classList.add("active");
      const logoNut = button.querySelector(".logo-nut");
      if (logoNut) {
        logoNut.src = logoActive;
        logoNut.classList.remove("logo-nut");
        logoNut.classList.add("logo-nut2");
      }
  
      if (marker) {
        marker.setIcon({
          url: markerActive,
          scaledSize: new google.maps.Size(46, 60),
        });
      }
  
      map.panTo(new google.maps.LatLng(
        parseFloat(value.coordenadas[0]),
        parseFloat(value.coordenadas[1])
      ));
      map.setZoom(10);
      button.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
    });
   
    markers.push(marker);

  });
}
