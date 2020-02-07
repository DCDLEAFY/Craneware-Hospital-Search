var marker;

// Initialize the platform object:
var platform = new H.service.Platform({
    apikey: 'iYvMpF1KOQJ89K6boSx23q7-l9Xtv4Jz3a5fun9MS1w'
});

/*
 * @param   {H.service.Platform} platform    A stub class to access HERE services
 */
//Function that uses geolocation if available
function getLocation(map) {
    //if supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Oops! This browser does not support HTML Geolocation.");
    }
}

//Put marker on map and center
function showPosition(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    map.setCenter({
        lat: lat,
        lng: lon
    });
    marker = new H.map.Marker({
        lat: lat,
        lng: lon
    });
    map.addObject(marker);

    //tracyMarker.getGeometry();
    //var distance = tracyMarker.getGeometry().distance(marker.getGeometry());
    //distance = distance *  0.000621; //turn into us miles
    //console.log(distance); //open browser console to view (Dundee is about 5k miles)
}
var pngIcon = new H.map.Icon("https://cdn1.iconfinder.com/data/icons/nuvola2/32x32/apps/kcmdrkonqi.png");

function restrictMap(map) {

    var bounds = new H.geo.Rect(72, -171, 19, -66.5);

    map.getViewModel().addEventListener('sync', function() {
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
    //Debug code to visualize where your restriction is
    /** map.addObject(new H.map.Rect(bounds, {
      style: {
          fillColor: 'rgba(55, 85, 170, 0.1)',
          strokeColor: 'rgba(55, 85, 170, 0.6)',
          lineWidth: 8
        }
      }
    ))
    */
    ;
}

function geocode(text) {
    var geocoder = platform.getGeocodingService(),
        geocodingParameters = {
            searchText: text,
            jsonattributes: 1
        };

    geocoder.geocode(
        geocodingParameters,
        onSuccess,
        onError
    );
}
/**
 * This function will be called once the Geocoder REST API provides a response
 * @param  {Object} result          A JSONP object representing the  location(s) found.
 *
 * see: http://developer.here.com/rest-apis/documentation/geocoder/topics/resource-type-response-geocode.html
 */
function onSuccess(result) {
    var locations = result.response.view[0].result;
    /*
     * The styling of the geocoding response on the map is entirely under the developer's control.
     * A representitive styling can be found the full JS + HTML code of this example
     * in the functions below:
     */
    addLocationsToMap(locations);
    addLocationsToPanel(locations);
    // ... etc.
}

/**
 * This function will be called if a communication error occurs during the JSON-P request
 * @param  {Object} error  The error message received.
 */
function onError(error) {
    alert('Can\'t reach the remote server');
}

// Get the default map types from the Platform object:
var defaultLayers = platform.createDefaultLayers();

// Instantiate the map:
var map = new H.Map(
    document.getElementById('mapContainer'),
    defaultLayers.vector.normal.map, {
        zoom: 4,
        center: {
            lng: -95,
            lat: 37
        }
    });

window.addEventListener('resize', () => map.getViewPort().resize());

// Enable the event system on the map instance:
var mapEvents = new H.mapevents.MapEvents(map);

// Add event listeners:
map.addEventListener('tap', function(evt) {
    // Log 'tap' and 'mouse' events:
    console.log(evt.type, evt.currentPointer.type);
});

// add a resize listener to make sure that the map occupies the whole container
window.addEventListener('resize', () => map.getViewPort().resize());
// Instantiate the default behavior, providing the mapEvents object:
var behavior = new H.mapevents.Behavior(mapEvents);

// Create the default UI with english settings:
var ui = H.ui.UI.createDefault(map, defaultLayers, 'en-US');

// Hold a reference to any infobubble opened
var bubble;

/**
 * Opens/Closes a infobubble
 * @param  {H.geo.Point} position     The location on the map.
 * @param  {String} text              The contents of the infobubble.
 */
function openBubble(position, text) {
    if (!bubble) {
        bubble = new H.ui.InfoBubble(
            position, {
                content: text
            });
        ui.addBubble(bubble);
    } else {
        bubble.setPosition(position);
        bubble.setContent(text);
        bubble.open();
    }
}

/**
 * Creates a series of list items for each location found, and adds it to the panel.
 * @param {Object[]} locations An array of locations as received from the
 *                             H.service.GeocodingService
 */
function addLocationsToPanel(locations) {

    var nodeOL = document.createElement('ul'),
        i;

    nodeOL.style.fontSize = 'small';
    nodeOL.style.marginLeft = '5%';
    nodeOL.style.marginRight = '5%';


    for (i = 0; i < locations.length; i += 1) {
        var li = document.createElement('li'),
            divLabel = document.createElement('div'),
            address = locations[i].location.address,
            content = '<strong style="font-size: large;">' + address.label + '</strong></br>';
        position = {
            lat: locations[i].location.displayPosition.latitude,
            lng: locations[i].location.displayPosition.longitude
        };

        content += '<strong>houseNumber:</strong> ' + address.houseNumber + '<br/>';
        content += '<strong>street:</strong> ' + address.street + '<br/>';
        content += '<strong>district:</strong> ' + address.district + '<br/>';
        content += '<strong>city:</strong> ' + address.city + '<br/>';
        content += '<strong>postalCode:</strong> ' + address.postalCode + '<br/>';
        content += '<strong>county:</strong> ' + address.county + '<br/>';
        content += '<strong>country:</strong> ' + address.country + '<br/>';
        content += '<br/><strong>position:</strong> ' +
            Math.abs(position.lat.toFixed(4)) + ((position.lat > 0) ? 'N' : 'S') +
            ' ' + Math.abs(position.lng.toFixed(4)) + ((position.lng > 0) ? 'E' : 'W');

        divLabel.innerHTML = content;
        li.appendChild(divLabel);

        nodeOL.appendChild(li);
    }

    locationsContainer.appendChild(nodeOL);
}


/**
 * Creates a series of H.map.Markers for each location found, and adds it to the map.
 * @param {Object[]} locations An array of locations as received from the
 *                             H.service.GeocodingService
 */
function addLocationsToMap(locations) {
    var group = new H.map.Group(),
        position,
        i;

    // Add a marker for each location found
    for (i = 0; i < locations.length; i += 1) {
        position = {
            lat: locations[i].location.displayPosition.latitude,
            lng: locations[i].location.displayPosition.longitude
        };
        marker = new H.map.Marker(position);
        marker.label = locations[i].location.address.label;
        marker.icon = pngIcon
        group.addObject(marker);
    }

    group.addEventListener('tap', function(evt) {
        map.setCenter(evt.target.getGeometry());
        openBubble(
            evt.target.getGeometry(), evt.target.label);
    }, false);

    // Add the locations group to the map
    map.addObject(group);
    map.setCenter(group.getBoundingBox().getCenter());
}

// Now use the map as required...

geocode("Miami");

restrictMap(map);

getLocation(map);