<script>    

        
        function show_taxi(km) {
            var lng = $('#length_km').val();
            for(i=1;i<=lng;i++) {
                var price_day = $('#price_day_'+i).val();
                var price_night = $('#price_night_'+i).val();
                var rout_price = (price_day * km + Number(price_day)).toFixed(2);
                $('#rout_price_'+i).text(rout_price+' Lei');
            }
            $('#table_taxi').show('slow');
            //console.log($('.length_km').length);
        }



        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map; 
  
        
        function get_distance(start_location,end_location){
            var mygc = new google.maps.Geocoder();
            var locationOrigem;
            var locationDestino;
            var latOrigem  = 0;
            var longOrigem = 0;
            var latDestino  = 0;
            var longDestino = 0;
            
                mygc.geocode({'address' : start_location}, function(results, status){
                     locationOrigem = results[0].geometry.location;
                     latOrigem   = results[0].geometry.location.lat();
                     longOrigem  = results[0].geometry.location.lng();
                mygc.geocode({'address' : end_location}, function(results, status){
                    locationDestino = results[0].geometry.location;
                    latDestino  = results[0].geometry.location.lat();
                    longDestino = results[0].geometry.location.lng();
                    //console.log(locationOrigem);
                    //console.log(locationDestino);
                    var km = google.maps.geometry.spherical.computeDistanceBetween(locationOrigem, locationDestino)/1000;
                    km = km.toFixed(2);
                    //console.log('Total km:'+km);
                    var message = $('#message').text();
                    message+= '! The route\'s length is : '+km+' km';
                    $('#message').empty().text(message);
                    $('<br>').appendTo($('body'));
                    for(i=1; i<5; i++) {
                        $('#km_'+i).val(km);
                    }
                    show_taxi(km);
                    $('#total_km').attr('km',km);
                });
            });
        }
 
 
 //var start_location = "Transilvaniei 6 Oradea",end_location = "Nufarului 46 Oradea";
 
        
        /*function test() {
            //console.log($('#start_long_lat').attr('coor')+" "+$('#end_long_lat').attr('coor'));
            var start = String($('#start_long_lat').attr('coor'));
            var end = String($('#end_long_lat').attr('coor'));
            var array_start = start.split(',');
            var array_end = end.split(',');
            console.log(array_start);
            console.log(array_end);
            var obj_start = {
                lat : array_start[0],
                lng : array_start[1]
            }
            var obj_end = {
                lat : array_end[0],
                lng : array_end[1]
            }
            console.log(google.maps.geometry.spherical.computeDistanceBetween (obj_start, obj_end));
        }*/
        
        function initialize() {
               
          directionsDisplay = new google.maps.DirectionsRenderer();
          var oradea = new google.maps.LatLng(47.072222, 21.921111);
          var mapOptions = {
            zoom:13,
            center: oradea
          };
          
          map = new google.maps.Map(document.getElementById('harta'), mapOptions);
          directionsDisplay.setMap(map);
        }
        
         //console.log('Setup -> : '+setup);
        function calcRoute() {
            $('#sep_line').show();
            var city = "Oradea";
            
           
            
            //console.log("return: "+$('#coordinate').length);
            if(setup){
                var start = setup;
                $('#message').text('You have chosen the start destination : '+start);
              } else {
                
                var start = document.getElementById('start').value;
                $('#message').text('You have chosen the start destination : '+start);
                var no_start = document.getElementById('no_start').value;
                var start  = start+" "+no_start+" "+city;
                var start_long_lat;
       
       $.post("ajax.php", {
            get_coo: 1,
            adress: start
       }, function(data,status){
             //console.log('Start: '+data);
             start_long_lat = data;
             $('#start_long_lat').attr('coor', start_long_lat);
             
       })
       
              }
            
          var end = document.getElementById('end').value;
          var no_end = document.getElementById('no_end').value;
          var end_long_lat;
          $('#message').text($('#message').text()+' No : '+no_start+' and the end destination : '+end+' No : '+no_end+' ');
          var end = end+" "+no_end+" "+city;
          
          $.post("ajax.php", {
            get_coo: 1,
            adress: end
       }, function(data,status){
             //console.log('End: '+data);
             end_long_lat = data;
             $('#end_long_lat').attr('coor', end_long_lat);
             
       })
       
          get_distance(start,end);
          //console.log(km);
          
          //console.log(start);
          //console.log(end);
          
          var request = {
              origin:start,
              destination:end,
              travelMode: google.maps.TravelMode.DRIVING
          };
          
          console.log(request);
          
          directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
              directionsDisplay.setDirections(response);
            }
          });
          
          
        }
        
        function report(name){
          console.log(name);
          var report = prompt('Write down your report');
          if(report) {
            $.post("ajax.php",{
              add_report : 1,
              report : report,
              name : name
            },function(data,status){
              alert(data);
            });
          }
        }
        
        $('#report').click(function(){
          report($('#driver_name').attr('data'));
        });
        
        $(document).ready(function(){
            google.maps.event.addDomListener(window, 'load', initialize);
            //$('').remove();
        });
        
        
        
</script>
</body>
</html>