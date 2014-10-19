<head>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script>
</head>

<script>
var customers_list = ['Popescu Stefan', 
                       'Catalin Dumbrava', 
                       'Timotei Stefan', 
                       'Catalin Smarandescu', 
                       'Ciprian Stoian',
                       'Nagy Levente', 
                       'Nagy Akos', 
                       'Steve Jobs', 
                       'Popa Catalina', 
                       'Corina Cret',
                       'Catalina Cret',
                       'Miscovici Iuliana',
                       'Catalina Stefanescu Barbu'];
                       
var destination = ['Independentei 24, Oradea',
                  'Ogorului 23, Oraea',
                  'Alesd 56, Bihor',
                  'Traian Lalescu 28, Oradea',
                  'Nufarului 45, Oradea',
                  'Onestilor 42, Oradea',
                  'Dragos Voda 12, Oradea',
                  'Cuza Voda 56, Oradea',
                  'Piata 1 Decembrie, Oradea',
                  'Matei Corvin 120, Oradea',
                  'Matei Corvin 23 , Oradea',
                  'Razboieni 34, Oradea']; 
                  
                                        
console.log(customers_list);
console.log(destination);

function get_distance(start_location,end_location,id_company,id_taxi,customers){
                    var mygc = new google.maps.Geocoder();
                    var locationOrigem;
                    var locationDestino;
                    var latOrigem  = 0;
                    var longOrigem = 0;
                    var latDestino  = 0;
                    var longDestino = 0;
                    
                    /*
                     console.log('Start Receive:');
                                         console.log(start_location);
                                         console.log(end_location);
                                         console.log(customers);
                                         console.log(id_taxi);
                                         console.log(id_company);
                     */
                    
             if(start_location && end_location){
                    
                mygc.geocode({'address' : start_location}, function(results, status){
                     locationOrigem = results[0].geometry.location;
                     latOrigem   = results[0].geometry.location.lat();
                     longOrigem  = results[0].geometry.location.lng();
                mygc.geocode({'address' : end_location}, function(results, status){
                    locationDestino = results[0].geometry.location;
                    latDestino  = results[0].geometry.location.lat();
                    longDestino = results[0].geometry.location.lng();
                    
                    var lat_lng_start = latOrigem+","+longOrigem;
                    var lat_lng_end = latDestino+","+longDestino;
                    
                    var km = google.maps.geometry.spherical.computeDistanceBetween(locationOrigem, locationDestino)/1000;
                    km = km.toFixed(2);
                    
                    $.post("ajax.php",{
                      send_auto_order: 1,
                      km: km,
                      start_location: start_location,
                      end_location: end_location,
                      id_company: id_company,
                      id_taxi: id_taxi,
                      customers: customers,
                      lat_lng_start: lat_lng_start,
                      lat_lng_end: lat_lng_end
                    },function(data,status){
                      console.log(data);
                      if(data){
                        console.log('The order is sent from the server!!!!!!!');
                        }
                      })
                    
                    
                    /*
                     console.log('Receive:');
                                         console.log(start_location);
                                         console.log(end_location);
                                         console.log(customers);
                                         console.log(id_taxi);
                                         console.log(id_company);
                                         console.log("KM:"+km);
                     */
                     
                     
                    
                })
           })
           
           }
           
  } 

setInterval(function(){
    
    $.post("ajax.php",{
         get_taxi_drivers: 1
    },function(json_data,status){
        var jsonObject =  JSON.parse( json_data );
        console.log(jsonObject);
        if(jsonObject){
            var destination_id_1 = 1 + Math.floor(Math.random() * 11);
            var destination_id_2 = 1 + Math.floor(Math.random() * 11);
            var customers_list_id = 1 + Math.floor(Math.random() * 12);
            console.log('number_1: '+destination_id_1);
            console.log('number_2: '+destination_id_2);
            
            if(destination_id_1 == destination_id_2){
                console.log('The number is egal!******************');
            }else{
            
              var id_taxi = jsonObject.Id;
              var id_company = jsonObject.id_company;
              var start_location = destination[destination_id_1];
              var end_location = destination[destination_id_2];
              var customers = customers_list[customers_list_id];
              
                    /*
                     console.log("SEND TO:"+start_location);
                     console.log("SEND TO:"+end_location);
                     console.log("SEND TO:"+customers);
                     console.log("SEND TO:"+id_taxi);
                     console.log("SEND TO:"+id_company);
                     */
              
              //init
              get_distance(start_location,end_location,id_company,id_taxi,customers);
            }
        
        }else{
            console.log('No free taxy driver in the moment!');
        }
    });
    
 }, 5000);

//setInterval live orders

setInterval(function(){
  $.post("ajax.php",{
    live_order_report: 1
  },function(data,status){
    $('#live_orders').html(data);
  })

}, 1000)

  

</script>

<div id="live_orders"></div>