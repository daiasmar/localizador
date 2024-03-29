document.addEventListener("DOMContentLoaded", (e) => {
  let data = new FormData();
  data.append("action", "localizador_ajax");

  fetch(admin_ajax.ajaxurl, {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((data) => {
      const provinciasDisponibles = Array.from(new Set(data.locations.map(location => location.provincia)));
      const provinciasOrdenadas = provinciasDisponibles.sort((a, b) => a.localeCompare(b, 'es', { sensitivity: 'base' }));    
      const apiGoogle = data.api;
      console.log(data.locations);
      window.initMap = async function () {
        const position = { lat: 40.4167754, lng: -3.7037902 };
        let themeSelect = data.theme;
        let themeActive = [];
        
        const silverTheme = [
            {
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#f5f5f5"
                }
              ]
            },
            {
              "elementType": "labels.icon",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#616161"
                }
              ]
            },
            {
              "elementType": "labels.text.stroke",
              "stylers": [
                {
                  "color": "#f5f5f5"
                }
              ]
            },
            {
              "featureType": "administrative.country",
              "stylers": [
                {
                  "visibility": "on"
                }
              ]
            },
            {
              "featureType": "administrative.land_parcel",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#bdbdbd"
                }
              ]
            },
            {
              "featureType": "administrative.locality",
              "stylers": [
                {
                  "visibility": "on"
                }
              ]
            },
            {
              "featureType": "administrative.neighborhood",
              "stylers": [
                {
                  "visibility": "on"
                }
              ]
            },
            {
              "featureType": "administrative.province",
              "stylers": [
                {
                  "color": "#000000"
                },
                {
                  "visibility": "on"
                },
                {
                  "weight": 1.5
                }
              ]
            },
            {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#eeeeee"
                }
              ]
            },
            {
              "featureType": "poi",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#757575"
                }
              ]
            },
            {
              "featureType": "poi.park",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#e5e5e5"
                }
              ]
            },
            {
              "featureType": "poi.park",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            },
            {
              "featureType": "road",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#ffffff"
                }
              ]
            },
            {
              "featureType": "road.arterial",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#757575"
                }
              ]
            },
            {
              "featureType": "road.highway",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#dadada"
                }
              ]
            },
            {
              "featureType": "road.highway",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#616161"
                }
              ]
            },
            {
              "featureType": "road.local",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            },
            {
              "featureType": "transit.line",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#e5e5e5"
                }
              ]
            },
            {
              "featureType": "transit.station",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#eeeeee"
                }
              ]
            },
            {
              "featureType": "water",
              "stylers": [
                {
                  "color": "#000000"
                },
                {
                  "visibility": "on"
                },
                {
                  "weight": 4
                }
              ]
            },
            {
              "featureType": "water",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#c9c9c9"
                }
              ]
            },
            {
              "featureType": "water",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            }
          ];
     
        const darkTheme  = [
          { elementType: 'geometry', stylers: [{ color: '#242f3e' }] },
          { elementType: 'labels.text.stroke', stylers: [{ color: '#242f3e' }] },
          { elementType: 'labels.text.fill', stylers: [{ color: '#746855' }] },
          {
            featureType: 'administrative.locality',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#d59563' }],
          },
          {
            featureType: 'poi',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#d59563' }],
          },
          {
            featureType: 'poi.park',
            elementType: 'geometry',
            stylers: [{ color: '#263c3f' }],
          },
          {
            featureType: 'poi.park',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#6b9a76' }],
          },
          {
            featureType: 'road',
            elementType: 'geometry',
            stylers: [{ color: '#38414e' }],
          },
          {
            featureType: 'road',
            elementType: 'geometry.stroke',
            stylers: [{ color: '#212a37' }],
          },
          {
            featureType: 'road',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#9ca5b3' }],
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry',
            stylers: [{ color: '#746855' }],
          },
          {
            featureType: 'road.highway',
            elementType: 'geometry.stroke',
            stylers: [{ color: '#1f2835' }],
          },
          {
            featureType: 'road.highway',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#f3d19c' }],
          },
          {
            featureType: 'transit',
            elementType: 'geometry',
            stylers: [{ color: '#2f3948' }],
          },
          {
            featureType: 'transit.station',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#d59563' }],
          },
          {
            featureType: 'water',
            elementType: 'geometry',
            stylers: [{ color: '#17263c' }],
          },
          {
            featureType: 'water',
            elementType: 'labels.text.fill',
            stylers: [{ color: '#515c6d' }],
          },
          {
            featureType: 'water',
            elementType: 'labels.text.stroke',
            stylers: [{ color: '#17263c' }],
          },
        ];

        if (themeSelect === "silver") {
          themeActive = silverTheme;
        } else if (themeSelect === "dark") {
          themeActive = darkTheme;
        }
        const esMovil = window.innerWidth < 768;
              const zoomPredeterminado2 = esMovil ? 5 : 6.2;
        map = new google.maps.Map(document.getElementById("map-localizador"), {
          
          zoom: zoomPredeterminado2,
          center: position,
          styles: themeActive
        });

        if (typeof getLocation === "function") {
          getLocation(data.locations, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.media.not_found, data.promotion.message, data.promotion.color, data.promotion.background, data.promotion.effect, provinciasOrdenadas);
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
              const esMovil = window.innerWidth < 768;
              const zoomPredeterminado = esMovil ? 5 : 6.2;
              map.panTo(centroPredeterminado);
              map.setZoom(zoomPredeterminado);
            } else if (localizacionesFiltradas.length > 0) {
              const esMovil2 = window.innerWidth < 768;
              const zoomPredeterminado3 = esMovil2 ? 7.7 : 9;
              const centroMapa = {
                lat: parseFloat(localizacionesFiltradas[0].coordenadas[0]),
                lng: parseFloat(localizacionesFiltradas[0].coordenadas[1]),
              };
              map.panTo(centroMapa);
              map.setZoom(zoomPredeterminado3);
            }

            getLocation(localizacionesFiltradas, data.media.marker, data.media.marker_active, data.media.logo, data.media.logo_active, data.media.not_found, data.promotion.message, data.promotion.color, data.promotion.background, data.promotion.effect, provinciasOrdenadas);
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
      loc.provincia.toLowerCase().startsWith(terminoBusqueda.toLowerCase()) ||
      loc.poblacion.toLowerCase().startsWith(terminoBusqueda.toLowerCase()) ||
      (loc.cp && String(loc.cp).startsWith(terminoBusqueda))
  );
}

function filtrarLocalizaciones(localizaciones, terminoBusqueda) {
  if (!terminoBusqueda) return localizaciones;

  const terminoNormalizado = terminoBusqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();

  return localizaciones.filter((loc) => {
    const provinciaNormalizada = loc.provincia.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    if (provinciaNormalizada.startsWith(terminoNormalizado)) return true;

    const poblacionNormalizada = loc.poblacion.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    if (poblacionNormalizada.startsWith(terminoNormalizado)) return true;

    if (loc.cp && String(loc.cp).startsWith(terminoBusqueda)) return true;

    return false;
  });
}

function limpiarMapaYContenedor() {
  document.getElementById("localPointsContainer").innerHTML = "";
  markers.forEach((marker) => marker.setMap(null));
  markers = [];
}

function getLocation(localizaciones, markerOnly, markerActive, logoOnly, logoActive, notFound, promoText, promotionColor, promotionBackground, promotionEffect, provinciasOrdenadas) {

  // MENSAJE SI NO HAY RESULTADO.
  const imageUrl = notFound; 

  if (localizaciones.length === 0) {
    const localPointsContainer = document.getElementById("localPointsContainer");

    if (imageUrl && imageUrl !== '') {
      const imageElement = document.createElement('img');
      imageElement.src = imageUrl;
      imageElement.className = 'imagen-lupa';
      imageElement.alt = 'Icono de no hay resultados';
      localPointsContainer.appendChild(imageElement);
    }

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

    provinciasOrdenadas.forEach(ciudad => {
        const customOption = document.createElement('span');
        customOption.className = 'custom-option text-calle';
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
 
  localizaciones.sort((a, b) => {
    const comparacionProvincia = a.provincia.localeCompare(b.provincia, 'es', { sensitivity: 'variant' });
    if (comparacionProvincia !== 0) return comparacionProvincia;
    return a.sede.localeCompare(b.sede, 'es', { sensitivity: 'variant' });
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
          otherButton.querySelector('.text-sede').classList.remove('active');
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
      button.querySelector('.text-sede').classList.add('active');
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
      map.setZoom(15);
    });

    const logoNut = logoOnly && logoOnly !== '' ? `<img src="${logoOnly}" class="logo-nut">` : '';
    const nombre = `<p class="text-sede"><b>${value.sede ? value.sede : "Sede no disponible"}</b></p>`;
    const direccion = `<p class="text-calle">${value.calle ? value.calle : "Dirección no disponible"
      }</p>`;
    const nombreCiudad = `<p class="text-direccion">${value.cp}, ${value.poblacion}, ${value.provincia}</p>`;
    const web = `<a class="text-info" href="${value.URL ? value.URL : "#"
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

    const esMovil = window.innerWidth < 768;
    const tamañoMarker = esMovil ? new google.maps.Size(25, 32) : new google.maps.Size(35, 42);


    const marker = new google.maps.Marker({
      map: map,
      position: new google.maps.LatLng(
        parseFloat(value.coordenadas[0]),
        parseFloat(value.coordenadas[1])
      ),
      title: value.sede,
      icon: markerOnly && markerOnly !== '' ? {
        url: markerOnly,
        scaledSize: tamañoMarker,
      } : undefined,
    });
    
    marker.addListener("click", () => {
      const useDefaultMarkerActive = !markerActive || markerActive === '';
      document.querySelectorAll(".button-points").forEach((otherButton, otherIndex) => {
        otherButton.classList.remove("active");
        otherButton.querySelector('.text-sede').classList.remove('active');
        const otherLogoNut = otherButton.querySelector(".logo-nut, .logo-nut2");
        if (otherLogoNut) {
          otherLogoNut.src = logoOnly;
          otherLogoNut.classList.remove("logo-nut2");
          otherLogoNut.classList.add("logo-nut");
        }
    
        if (markers[otherIndex]) {
          markers[otherIndex].setIcon(useDefaultMarkerActive ? {} : {
            url: markerOnly,
            scaledSize: new google.maps.Size(35, 45),
          });
        }
      });
    
      const button = document.querySelectorAll(".button-points")[index];
      button.classList.add("active");
      const textSede = button.querySelector('.text-sede');
      if (textSede) {
        textSede.classList.add('active');
      }
      const logoNut = button.querySelector(".logo-nut");
      if (logoNut) {
        logoNut.src = logoActive;
        logoNut.classList.remove("logo-nut");
        logoNut.classList.add("logo-nut2");
      }
    
      if (marker) {
        const esMovilActive = window.innerWidth < 768;
        const tamañoMarkerActive = esMovilActive ? new google.maps.Size(38, 50) : new google.maps.Size(46, 60);
        marker.setIcon(useDefaultMarkerActive ? {} : {
          url: markerActive,
          scaledSize: tamañoMarkerActive,
        });
      }
    
    
      map.panTo(new google.maps.LatLng(
        parseFloat(value.coordenadas[0]),
        parseFloat(value.coordenadas[1])
      ));
      map.setZoom(15);
      button.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
    });
    
    markers.push(marker);

  });

  if(promotionEffect){
    const promoBanners =  document.querySelectorAll('.promo-banner');

    promoBanners.forEach(promoBanner => {
      const originalCont = promoBanner.querySelector('.promo-content');

      let totalWidth = originalCont.clientWidth;
      const computedStyle = window.getComputedStyle(originalCont);
      const marginRight = parseInt(computedStyle.marginRight);
      
      let position = 0;
      let decrementAmount = 0.075;

      while (totalWidth < promoBanner.clientWidth) {
          const clone = originalCont.cloneNode(true);
          promoBanner.appendChild(clone);
          totalWidth += clone.clientWidth + marginRight; 
      }
      
      const promoContents = promoBanner.querySelectorAll('.promo-content');
      
      function moveTexts() {
        promoContents.forEach(content => {
          position -= decrementAmount;
          if (position < -content.clientWidth) {
            position = marginRight;
          }
          content.style.left = position + 'px';
        });
        requestAnimationFrame(moveTexts);
      }
      moveTexts();
    })
  }
}
