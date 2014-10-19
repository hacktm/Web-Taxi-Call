   var setup;

   /*
     
        
            var Geo={};
            if (navigator.geolocation) {
               console.log("start"); 
               navigator.geolocation.getCurrentPosition(success, error);
            }
            //Get the latitude and the longitude;
            function success(position) {
                Geo.lat = position.coords.latitude;
                Geo.lng = position.coords.longitude;
                //populateHeader(Geo.lat, Geo.lng);
                setup = Geo.lat+" , "+Geo.lng;
                //$('#coordinate').text(coordinate);
                $('#start_location').empty().text('Start location has been selected');
            }

            function error(){
                console.log("Geocoder failed");
             }
             
    */
         
         
var rad = function(x) {
  return x * Math.PI / 180;
};

var getDistance = function(p1, p2) {
  var R = 6378137; // Earth’s mean radius in meter
  var dLat = rad(p2.lat() - p1.lat());
  var dLong = rad(p2.lng() - p1.lng());
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
    Math.sin(dLong / 2) * Math.sin(dLong / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c;
  return d; // returns the distance in meter
};

function set_comp(id_comp) {
    $('#id_comp').attr('comp',id_comp);
}


function debug(){
  var start = $('#start').val()+' '+$('#no_start').val()+' '+',Oradea';
  var end = $('#end').val()+' '+$('#no_end').val()+' '+',Oradea';
  
  console.log(start);
  console.log(end);
}

function send_order(){
    //$('#navbar_index').remove();
    var name = $('#name').val();
    var phone = $('#phone').val();
    var comment = $('#comment').val();
    var id_comp = $('#id_comp').attr('comp');
    var start = $('#start').val()+' '+$('#no_start').val()+' '+',Oradea';
    var end = $('#end').val()+' '+$('#no_end').val()+' '+',Oradea';
    
    //console.log(start);
    //console.log(end);
    
    if(name&&phone) {
        if(phone.length == 10) {
            var long_lat_start = $('#start_long_lat').attr('coor');
            var long_lat_end = $('#end_long_lat').attr('coor');
            var total_km = $('#total_km').attr('km');
            //var start = $('#start').val()+' '+$('#no_start').val()+' '+',Oradea';
            //var end = $('#end').val()+' '+$('#no_end').val()+' '+',Oradea';
            
            
            
            $.post("ajax.php",{
                send_order: 1,
                name : name,
                phone : phone,
                id_company : id_comp,
                comment : comment,
                long_lat_start : long_lat_start,
                long_lat_end : long_lat_end,
                total_km : total_km,
                start : start,
                end : end
            },function(data, status){
                taxi_response();
                $('#test_modal').hide();
                $('.modal-backdrop').remove();
                alert(data);
            });
        } else {
            alert('The phone number is not correct');
        }
    } else {
        alert('You must complete the name and phone number fields.');
    }
}

function taxi_response(){
    
    setInterval(function(){
        $.post("ajax.php",{
            taxi_response_check:1
        },function(data,status){
            //console.log(data);
            if(data == "Please wait until the order will be retrived !"){
               $('#taxi_response').html(data); 
            }else{
               //$.scrollTo( $('#scrool_bottom'), 500);
               $('#table_taxi').hide('slow');
               //document.getElementById('audiotag1').play();
               $('#taxi_response').html(data); 
            }
        })
    }, 5000);
    
}

function command_retrieve(id_order,id_taxi) {
    $.post("ajax.php",{
        command_retrieve :1,
        id_order : id_order,
        id_taxi : id_taxi
    },function(data,status){
        //$('#order_maps').html(data);
        
        var url = 'order_maps.php?id_order='+data+'';
        window.open(url,'_blank');
        //console.log(url);
        
    });
}

function show_maps(lng_lat_start,location_start,location_end){
  //console.log(lng_lat_start +" --- "+ lng_lat_end);
  var url = 'show_maps.php?location_start_latlng='+lng_lat_start+'&location_start='+location_start+'&location_end='+location_end;
  window.open(url,'_blank');
}  







    