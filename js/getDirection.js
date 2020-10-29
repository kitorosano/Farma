

const mapStart = () => {

  let map = new H.Map(
    document.getElementById("map"),
    defaultLayers.vector.normal.map,
    {
      center: { lat: -32, lng: -58 },
      zoom: 14,
    }
  );

  const ui = H.ui.UI.createDefault(map, defaultLayers);
  ui.getControl("mapsettings").setDisabled(true).setVisibility(false);
  ui.getControl("zoom").setAlignment("bottom-right");
  ui.getControl("scalebar").setAlignment("bottom-right");

  return map;

};

const marker = direccion => {

  let fromMarker = new H.map.Marker(
    {
      lat: direccion.lat,
      lng: direccion.lng,
    },
    {volatility: true}
  );
  fromMarker.draggable = true;

  return fromMarker;
};
