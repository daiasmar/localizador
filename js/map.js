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
      const apiGoogle = data.api;

      window.initMap = async function () {
        const position = { lat: 40.4167754, lng: -3.7037902 };
        map = new google.maps.Map(document.getElementById("map-localizador"), {
          zoom: 6.2,
          center: position,
        });

        if (typeof getLocation === "function") {
          getLocation(data.locations);
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
              // Si el término de búsqueda está vacío o no hay ubicaciones filtradas, establece el centro y zoom predeterminados
              const centroPredeterminado = {
                lat: 40.4167754,
                lng: -3.7037902,
              };
              const zoomPredeterminado = 6.2;
              map.setCenter(centroPredeterminado);
              map.setZoom(zoomPredeterminado);
            } else if (localizacionesFiltradas.length > 0) {
              const centroMapa = {
                lat: parseFloat(localizacionesFiltradas[0].coordenadas[0]),
                lng: parseFloat(localizacionesFiltradas[0].coordenadas[1]),
              };
              map.setCenter(centroMapa);
              map.setZoom(10);
            }

            getLocation(localizacionesFiltradas);
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

function getLocation(localizaciones) {
  //Orden de ciudad por alfabeto
  localizaciones.sort((a, b) => {
    if (a.ciudad < b.ciudad) return -1;
    if (a.ciudad > b.ciudad) return 1;

    // Si las ciudades son iguales, compara por sede
    return a.sede.localeCompare(b.sede);
  });

  const localPointsContainer = document.getElementById("localPointsContainer");
  //NOTA: Este forEach crea los botones iterando por el objeto.
  localizaciones.forEach((value, index) => {
    console.log(value);
    const button = document.createElement("button");
    button.classList.add("button-points", "dis-flex");

    const logoNut =
      '<img src="http://localhost/nut/wp-content/uploads/2024/01/NUT_LOGO_2.svg" class="logo-nut">';
    const logoNut2 =
      '<img src="http://localhost/nut/wp-content/uploads/2024/01/logotipo_nut-2.svg" class="logo-nut2">';

    const nombre = `<p>${value.sede ? value.sede : "Sede no disponible"}<p>`;
    const direccion = `<p>${
      value.calle ? value.calle : "Dirección no disponible"
    }<p>`;
    const web = `<a href="${
      value.URL ? value.URL : "#"
    }" target="_blank">+ info</a>`;
    const buttonContent = `
      <div class="sede-click">
          ${logoNut}
          <div class="box-text-1">
              ${nombre}
              ${direccion}
          </div>
      
      <div class="box-text-2">
          ${web}
      </div>
      </div>`;

    console.log(
      `logoNut: ${logoNut}, nombre: ${nombre}, direccion: ${direccion}, web: ${web}`
    );

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
        url: "http://localhost/nut/wp-content/uploads/2024/01/icono-nut.png", //NOTA: El icono del logo tenemos que enviarlo por url guardandolo en la tabla.
        scaledSize: new google.maps.Size(35, 42),
      },
    });

    markers.push(marker);

    const sedeClickElements = button.getElementsByClassName("sede-click");
    for (const sedeClickElement of sedeClickElements) {
      sedeClickElement.addEventListener("click", () => {
        document.querySelectorAll(".sede-click").forEach((btn, idx) => {
          btn.classList.remove("active");
          const logoNut = btn.querySelector(".logo-nut");
          if (logoNut) {
            logoNut.classList.remove("active");
          }
          markers[idx].setIcon({
            url: "http://localhost/nut/wp-content/uploads/2024/01/icono-nut.png",
            scaledSize: new google.maps.Size(35, 45),
          });
        });

        sedeClickElement.classList.add("active");
        const logoNutElement = sedeClickElement.querySelector(".logo-nut");
        if (logoNutElement) {
          logoNutElement.classList.add("active");
        }

        markers[index].setIcon({
          url: "http://localhost/nut/wp-content/uploads/2024/01/icono-nut.png",
          scaledSize: new google.maps.Size(46, 60),
        });

        map.panTo(
          new google.maps.LatLng(
            parseFloat(value.coordenadas[0]),
            parseFloat(value.coordenadas[1])
          )
        );
        setTimeout(() => {
          map.setZoom(10);
        }, 1000);
      });
    }
  });
}
