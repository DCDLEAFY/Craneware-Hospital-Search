//not working
//import { hereCredentials } from './config.js';
/**
 * TODO bounding box seems to go left when out of right bounds,
 * goes either to bottom left or right when going bottom out of bounds
 * goes top left/ right when going top out of bounds
 * only going left works as intended
 **/
/**
 * Restricts the Map around the US - included with Alaska and Hawaii
 * 
 **/
function restrictMap(map) {

    var bounds = new H.geo.Rect(72, -171.5, 19, -66.5);
    var no = false;

    map.getViewModel().addEventListener('sync', function () {
        var center = map.getCenter();
        if (!bounds.containsPoint(center)) {
            if (center.lat > bounds.getTop()) {
                center.lat = bounds.getTop();
            } else if (center.lat < bounds.getBottom()) {
                center.lat = bounds.getBottom();
            }
            if (center.lng < bounds.getLeft()) {
                center.lng = bounds.getLeft();
    } else if (center.lng > bounds.getRight()) {
                center.lng = bounds.getRight();
            }
            map.setCenter(center);
        }
    });
}
//TODO Seperate this file into multiple functions/js files?
// Initialize the platform object:
var platform = new H.service.Platform({
    apikey: 'PjNiDxIXsLVxtd84WDfqGpUDTl6aDqgh4WE2tRMxTBc'
    //not working
    //apikey: hereCredentials.apikey
});

// Get the default map types from the Platform object:
var defaultLayers = platform.createDefaultLayers();

// Instantiate the map:
var map = new H.Map(
    document.getElementById('mapContainer'),
    defaultLayers.vector.normal.map,
    {
        zoom: 4,
        center: { lng: -95, lat: 37  }
    });

// Enable the event system on the map instance:
var mapEvents = new H.mapevents.MapEvents(map);

// Add event listeners:
map.addEventListener('tap', function (evt) {
    // Log 'tap' and 'mouse' events:
    console.log(evt.type, evt.currentPointer.type);
});

// add a resize listener to make sure that the map occupies the whole container
window.addEventListener('resize', () => map.getViewPort().resize());
// Instantiate the default behavior, providing the mapEvents object:
var behavior = new H.mapevents.Behavior(mapEvents);

// Create the default UI with english settings:
var ui = H.ui.UI.createDefault(map, defaultLayers, 'en-US');

restrictMap(map);