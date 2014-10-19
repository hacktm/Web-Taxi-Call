<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <style>
      html, body, #map {
        height: 99%;
        width: 99%;
        padding: 0px;
      }
      #map {
        border:4px solid grey;
        margin-left: auto;
        margin-top: auto;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
      window.onload = function(){
        console.log('<?php echo $_GET['location_start']; ?>');
        console.log('<?php echo $_GET['location_end']; ?>');
      };
    </script>
    <script>
      var directionsDisplay;
      var directionsService = new google.maps.DirectionsService();
      var map;
      
      function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var center = new google.maps.LatLng(<?php echo $_GET['location_start_latlng']; ?>);
        var mapOptions = {
          zoom:10,
          center: center
        };
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        directionsDisplay.setMap(map);
      }
      
      function calcRoute() {
        var start = '<?php echo $_GET['location_start']; ?>';
        var end = '<?php echo $_GET['location_end']; ?>';
        var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });
      }
      var toLoad = function(){
        initialize();
        calcRoute();
      };
      google.maps.event.addDomListener(window, 'load', toLoad);

    </script>
  </head>
  <body>
    <div id="map"></div>
  </body>
</html>