/*
 * Calcular distacia entre cliente y farmacia,
 * Mostrarlo en un mapa.
 * 
 * Se utilizo Here API.
 */
const platform = new H.service.Platform({
  "apikey": "MjT4Z-c7kBrLpicDHQm5hwj6HBNJIhYiYmjtdxAQK24"
});

const service = platform.getSearchService();
const router = platform.getRoutingService(null, 8);
const defaultLayers = platform.createDefaultLayers();

let map, fromMarker;


const geocoder = query => {
  return new Promise((resolve, reject) => {
    service.geocode({
        q: query + " Paysandu, Uruguay"
      },
      (success) => {
        resolve(success.items[0].position);

      },
      (error) => {
        reject(error);
      });
  });
}


async function start(direccion) {
  if (!map) {
    const from = await geocoder(direccion);
    fromMarker = new H.map.Marker({
      lat: from.lat,
      lng: from.lng
    });

    map = new H.Map(
      document.getElementById("map"),
      defaultLayers.vector.normal.map, {
        zoom: 17,
        center: {
          lat: from.lat,
          lng: from.lng
        }
      }
    );
    map.addObject(fromMarker);
  }

  const ui = H.ui.UI.createDefault(map, defaultLayers);
  ui.getControl('mapsettings').setDisabled(true).setVisibility(false);
  ui.getControl('zoom').setAlignment('bottom-right');
  ui.getControl('scalebar').setAlignment('bottom-right');
  const mapEvents = new H.mapevents.MapEvents(map);
  const behavior = new H.mapevents.Behavior(mapEvents);

}