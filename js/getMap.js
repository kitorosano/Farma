const mapStart = data => {
  let map = new H.Map(
    document.getElementById("map"),
    defaultLayers.vector.normal.map,
    {
      zoom: 14,
      center: {
        lat: data[0],
        lng: data[1],
      },
    }
  );

  const mapBehavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
  const ui = H.ui.UI.createDefault(map, defaultLayers);
  ui.getControl("mapsettings").setDisabled(true).setVisibility(false);
  ui.getControl("zoom").setAlignment("bottom-right");
  ui.getControl("scalebar").setAlignment("bottom-right");

  return map;
};
