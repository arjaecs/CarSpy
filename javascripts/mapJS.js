    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;
    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();

        var options =
        {
            zoom: 10,
            center: new google.maps.LatLng(geoip_latitude(), geoip_longitude()),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions:
            {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_RIGHT,
                mapTypeIds: [google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.TERRAIN,
                google.maps.MapTypeId.HYBRID,
                google.maps.MapTypeId.SATELLITE]
            },
            navigationControl: true,
            navigationControlOptions:
            {
                style: google.maps.NavigationControlStyle.ZOOM_PAN
            },
            scaleControl: true,
            disableDoubleClickZoom: true,
            draggable: true,
            streetViewControl: true,
            draggableCursor: 'move'
        };
        map = new google.maps.Map(document.getElementById("map"), options);
        directionsDisplay.setMap(map);
            // Add Marker and Listener
            var latlng = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
            calcRoute();

        }

        function calcRoute() {
            var start = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
            var end = new google.maps.LatLng(<?php echo $event['GPS'] ?>);
            var request = {
                origin:start,
                destination:end,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);
                }
            });
        }
        window.onload = initialize;