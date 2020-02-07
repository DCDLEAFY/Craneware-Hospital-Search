<!DOCTYPE html>
<!-- Language the website is written in -->
<html lang="en">
<!-- Including the connection.php file that connects the website to the database -->
<?php include_once 'connection.php'; ?>
<!-- Start of head -->

<head>
    <!-- This contains the data that will be shown on the tab's title in the browser -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Craneware Maps</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Here Maps Library -->
    <meta name="viewport" content="initial-scale=1.0,
            width=device-width" /> <!-- mobile compatibiity-->
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script> <!-- map UI-->
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script> <!-- enables interactve map-->
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <!--<script src="js/map.js" type="text/javascript"></script> -->

</head>
<!-- End of head -->
<!-- Start of body of the website-->

<body>

    <!-- Navigation bar for the website ////// ! why is this here, you havet his code elsewhere too-->
    <?php include_once 'navigationBar.php'; ?>
    <?php
    $procedureD = $_POST['procedureList'];
    $stateD = $_POST['stateList'];
    // SQL query to find the procedure that the patient chose in the index.php based on the procedure code provided by the index.php
    $sql = "SELECT DISTINCT procedureID, procedures FROM 19agileteam12db.data WHERE extendedProcedures = \"$procedureD\";";
    $result1 = $con->query($sql);
    $row = mysqli_fetch_array($result1);
    $procedureID = $row['procedureID'];
    ?>
    <br>
    <!-- Main Body -->
    <div class="container">
        <!-- Table used to show the procedure to the patient -->
        <table class="table table-striped table-borderless">
            <thead class="thead-dark">
                <tr>
                    <th>Procedure code:</th>
                    <td>
                        <?php
                        echo $procedureID;
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Procedure:</th>
                    <td>
                        <?php
                        echo $procedureD;
                        ?>
                    </td>
                </tr>
            </thead>
        </table>
        <!-- First div -->
        <div class="col-lg-12 text-center">
            <div style=" width: 100%; height: 580px" id="mapContainer">
            </div>
        </div>

        <!-- Second div -->
        <div class="col-lg-12 text-left">
            <?php
            $procedureD = $_POST['procedureList'];
            $stateD = $_POST['stateList'];
            $priceMax = $_POST['priceSlider'];
            $distanceMax = $_POST['distanceSlider'];
            $rank = 1;
            $list = "";
            // SQL query to receive the details of the available hospitals from the database
            $sql = "SELECT providerId, providerName, providerAddress, providerCity, providerState, providerZipCode, regionDescription, averageTotalPayment FROM 19agileteam12db.data WHERE providerState = \"$stateD\" AND extendedProcedures = \"$procedureD\" AND averageTotalPayment <= $priceMax ORDER BY averageTotalPayment ASC;";
            $result = $con->query($sql);
            //Start of the table container, to contain the details of the available hospitals depending on the procedure and the state
            // While loop used to list the available hospitals and their details on the table

            while ($row = mysqli_fetch_array($result)) {
                echo "
          <br>
          <div style=\"border: 2px solid grey; border-radius:25px\">
          <br>
          <table class=\"table table-striped table-borderless\">
          <thead class=\"thead-dark\">
            <tr>
              <td style=\"width:10%\"></td>
              <th style=\"width:25%\">Hospital Name:</th>
              <td> " . $row['providerName'] . " </td>
            </tr>
            <tr>
              <td><b> <div style=\"border: 2px solid green; text-align:center; border-radius:25px\">" . $rank . "<div><b></td>
              <th>Address:</th>
              <td> " .  $row['providerAddress'] . " " . $row['providerCity'] . " " . $row['providerZipCode'] . " " . $row['regionDescription'] . "</td>
            </tr>
            <tr>
              <td></td>
              <th>Price:</th>
              <td> $ " . $row['averageTotalPayment'] . "</td>
            </tr>
          </thread>
          </table>
          </div>";

                $address = $row['providerAddress'] . " " . $row['providerCity'] . " " . $row['providerZipCode'] . " " . $row['regionDescription'];
                $rank = $rank + 1;
                $list = $list . " , " . $address;
            }
            mysqli_next_result($con);
            $hardAddress = "Florida";
            ?>
            <script type="text/javascript">

            </script>

        </div>
        <ul class="list-unstyled" style="text-align:center">
            <br>
            <li>Bootstrap 4.3.1</li>
            <li>jQuery 3.4.1</li>
        </ul>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.slim.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        var marker;
        var pngIcon = new H.map.Icon("https://cdn1.iconfinder.com/data/icons/nuvola2/32x32/apps/kcmdrkonqi.png");
        var map;
        var userPosition;
        var distance;
        var range = '<?php echo $distanceMax; ?>';

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
            userPosition = new H.map.Marker({
                lat: lat,
                lng: lon
            });
            map.addObject(userPosition);
            var listAddress = "<?php echo $list; ?>";
            var Arr = listAddress.split(',');

            for (i = 1; i < Arr.length; i++) {
                geocode(Arr[i]);
            }
            //tracyMarker.getGeometry();
            //var distance = tracyMarker.getGeometry().distance(marker.getGeometry());
            //distance = distance *  0.000621; //turn into us miles
            //console.log(distance); //open browser console to view (Dundee is about 5k miles)
        }

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
        if (typeof map === 'undefined' || map === null) {
            map = new H.Map(
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

            window.addEventListener('resize', () => map.getViewPort().resize());
        }

        // add a resize listener to make sure that the map occupies the whole container
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

                distance = Math.round(userPosition.getGeometry().distance(marker.getGeometry()) * 0.000621)


                if (range > distance) {
                    group.addObject(marker);
                }
            }

            group.addEventListener('tap', function(evt) {
                map.setCenter(evt.target.getGeometry());
                openBubble(
                    evt.target.getGeometry(), evt.target.label);
            }, false);

            //if(range < distance){
            map.addObject(group);
            map.setCenter(group.getBoundingBox().getCenter());
            //}
        }

        // Now use the map as required...




        restrictMap(map);

        getLocation(map);
    </script>

</body>
<!-- End of body -->

</html>
<!-- End of HTML file -->