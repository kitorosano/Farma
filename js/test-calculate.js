/*
 * Calcular distacia entre cliente y farmacia,
 * Mostrarlo en un mapa.
 *
 * Se utilizo Here API.
 */
const platform = new H.service.Platform({
  apikey: "MjT4Z-c7kBrLpicDHQm5hwj6HBNJIhYiYmjtdxAQK24",
});

//Llamar a los servicios de BUSQUEDA y RASTREO DE RUTA
const service = platform.getSearchService();
const router = platform.getRoutingService(null, 8);

//Pasar de Direccion a Coordenadas, funciona con promesa.
const geocoder = (query) => {
  return new Promise((resolve, reject) => {
    service.geocode(
      {
        q: query + "Paysandu, Uruguay",
      },
      (success) => {
        resolve(success.items[0].position);
      },
      (error) => {
        reject(error);
      }
    );
  });
};

const getLocals = () => {
  return new Promise((resolve, reject) => {
    fetch("includes/locals.json")
      .then((response) => response.json())
      .then((data) => resolve(data))
      .catch((error) => reject(error));
  });
};

const start = async (direccion) => {
  // Convierte las direcciones en coordenadas para el mapa,
  const casaDireccion = await geocoder(direccion);
  const locals = await getLocals();
  // console.log(casaDireccion, locals);

  // Marcador DIRECCION DEL CLIENTE
  const marker1 = new H.map.Marker({
    lat: casaDireccion.lat,
    lng: casaDireccion.lng,
  });

  let farmacia;
  let lastDistance=Infinity;
  for (let local of Object.entries(locals)){
    const marker2 = new H.map.Marker({
      lat: local[1][0],
      lng: local[1][1],
    });
    const newDistance = marker1.getGeometry().distance(marker2.getGeometry());
    
    if(newDistance < lastDistance) {
      console.log(newDistance)
      farmacia=local
      lastDistance=newDistance;
    }
  }

  console.log(farmacia);

  document.getElementById("distancia").value = distance;
};


const direccion = document.getElementById("direccion").value;
const farmacias = document.getElementById("farmacias").value;
console.log(farmacias);
start(direccion, farmacias);
