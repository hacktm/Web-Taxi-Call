<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete Address Form</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta charset="utf-8"/>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style>
      .pac-container:after {
          background-image: none !important;
          height: 0px;
      }
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
    var placeSearch, autocomplete;
    function initialize_start() {
      autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('start_location')),
          { types: ['geocode'] });
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
      });
    }
    function initialize_end() {
      autocomplete = new google.maps.places.Autocomplete(
          (document.getElementById('end_location')),
          { types: ['geocode'] });
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        callBack();
      });
    }
    function onLoadInit() {
      initialize_start();
      initialize_end();
    }
    function callBack() {
      console.log('callback');
    }
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = new google.maps.LatLng(
              position.coords.latitude, position.coords.longitude);
          autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
              geolocation));
        });
      }
    }
    </script>
    <style>
      #start_location {
        width: 40%; float:left; margin:10px;
      }
      #end_location {
        width: 40%; float:left; margin:10px;
      }
      #locationField {
        margin-left:4%;
      }
    </style>
  </head>

  <body onload="onLoadInit()">
    <div id="locationField">
      <input data-provide="typeahead" id="start_location" placeholder="Enter your address" onFocus="geolocate()" type="text"/></input>
      <input data-provide="typeahead" id="end_location" placeholder="Enter your address" onFocus="geolocate()" type="text"/></input>
    </div>
  </body>
</html>