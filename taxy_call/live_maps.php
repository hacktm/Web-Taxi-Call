<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Live Maps</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAi_x03rBPvcUzObU_OU5Z_RRMrZ4ZiepwBPC13G1CO0mIcOaHJBSF-jlBQxmGDKmcezkCQdycMczfaQ" type="text/javascript"></script>
    <script src="js/epoly.js" type="text/javascript"></script>
    <style type="text/css">
<!--
body {
	font: 14px "Trebuchet MS", Verdana, sans-serif;
	background: #FFFFCC;
}
.style1 {font-size: 18px}
-->
    </style>
</head>

  <body onunload="GUnload()">
<div align="center">

    <div id="controls">
    </div>

<div id="map" style="width: 100%; height: 550px"></div>
<table id="carsdata" width="100%"></table>


<script type="text/javascript">

//<![CDATA[

$('#carsdata').append(
        '<tr valign="top">'+
            '<td width="10%" class="customer_name"><strong>Customer Name</strong></td>'+
            '<td width="10%" class="customer_phone_nr"><strong>Customer Phone Nr</strong></td>'+
            '<td width="10%" class="start_destination"><strong>Start Destination</strong></td>'+
            '<td width="10%" class="End_destination"><strong>End Destination</strong></td>'+
            '<td width="10%" class="step"><strong>Step</strong></td>'+
            '<td width="10%" class="distance"><strong>Distance</strong></td>'+
            '<td width="10%" class="speed"><strong>Speed</strong></td>'+
            '<td width="60%" class="next"><strong>Next</strong></td>'+
        '</tr>'
);

function directClass( startpoint, endpoint, stepDefault, tick, carID, customer_name, start_destination, end_destination, total_km, customer_phone_nr, order_id ) {

//  var step = 50; // metres
//  var tick = 10; // milliseconds
	var eol;
	var poly;
	var car = new GIcon();
	car.image="img/car.png"
	car.iconSize=new GSize(32,37);
	car.iconAnchor=new GPoint(16,35);
	var marker;
	var k=0;
	var stepnum = 0;
	var speed = "";   
	var d = 0;
	var step = stepDefault;

	function startAnimate() {
		d = 0;
		animate();
	}

	var dirn = new GDirections();
	dirn.loadFromWaypoints([startpoint,endpoint],{getPolyline:!true,getSteps:true});

	GEvent.addListener(dirn,"error", function() {
		alert("Location(s) not recognised. Code: "+dirn.getStatus().code);
	});

	GEvent.addListener(dirn,"load", function() {
			document.getElementById("controls").style.display="none";
			poly = this.getPolyline();
			eol = poly.Distance();
//			map.setCenter(poly.getVertex(0),17);
			map.addOverlay(new GMarker(poly.getVertex(0),G_START_ICON));
			map.addOverlay(new GMarker(poly.getVertex(poly.getVertexCount()-1),G_END_ICON));
			marker = new GMarker(poly.getVertex(0),{icon:car});
			map.addOverlay(marker);
			var steptext = this.getRoute(0).getStep(stepnum).getDescriptionHtml();
//			document.getElementById("step").innerHTML = steptext;
			$("#car"+carID+" .step").html( steptext );
			// $("#car"+carID+" .step").append( "<br>".steptext );
			startAnimate();
		});
        
        $('#car'+carID+'').remove();   

$('#carsdata').append(
        '<tr id="car'+carID+'" valign="top">'+
        '<td width="10%" class="customer_name"></td>'+
        '<td width="10%" class="customer_phone_nr">'+customer_phone_nr+'</td>'+
        '<td width="10%" class="start_destination"><strong>'+start_destination+'</td>'+
        '<td width="10%" class="end_destination"><strong>'+end_destination+'</strong></td>'+
        '<td width="20%" class="step"></td>'+
        '<td width="10%" class="distance"></td>'+
        '<td width="10%" class="speed"></td>'+
        '<td width="60%" class="next"></td></tr>'
);
//    <div class="style1" id="step">&nbsp;</div>
//    <div class="style1" id="distance">Miles: 0.00</div>
  
	function animate() {


		if ( d > eol ) {
		    
            
             $.post("ajax.php",{
                 end_order_taxi: 1,
                 id_taxi: carID,
                 id_order: order_id
             },function(data,status){
                if(data == "ok"){
                    $("#car"+carID+" .step").html('<b>The Order Is Completed</b>');
                }
             });
 
             
            //console.log("*******************"+order_id); 
            
            $("#car"+carID+" .step").html('<b>The Order Is Completed</b>');


			$("#car"+carID+" .distance").html("Miles: "+(d/1609.344).toFixed(2));

//document.getElementById("step").innerHTML = "<b>Trip completed</b>";
//document.getElementById("distance").innerHTML =  "Miles: "+(d/1609.344).toFixed(2);
			return;
		}

		var p = poly.GetPointAtDistance(d);
        
		if (k++>=180/step) {
//          map.panTo(p);
//			k=0;
		}
		marker.setPoint(p);

/*
console.log(  dirn.getRoute(0) );
console.log(  dirn.getRoute(0).getStep(stepnum) );
console.log( dirn.getRoute(0).getStep(stepnum).getPolylineIndex() );
console.log(  poly.GetIndexAtDistance(d) );
console.log(  d );



jksghjklsafg();
*/

var q = poly.GetIndexAtDistance(d);
 //console.log(q);

		// document.getElementById("distance").innerHTML =  "Miles: "+(d/1609.344).toFixed(2)+speed;
		$("#car"+carID+" .distance").html("Miles: "+(d/1609.344).toFixed(2)+speed);
        $("#car"+carID+" .customer_name").html(customer_name);

//  var step = stepDefault;

        	var e = 0;
		if ( d > e+1 ) {
			//
		}

		if ( stepnum+1 < dirn.getRoute(0).getNumSteps()) {
			if ( dirn.getRoute(0).getStep(stepnum).getPolylineIndex() < poly.GetIndexAtDistance(d) ) {
				stepnum++;
				var steptext = dirn.getRoute(0).getStep(stepnum).getDescriptionHtml();
				// document.getElementById("step").innerHTML = "<b>Next:</b> "+steptext;

				$("#car"+carID+" .next").html( "<b>Next:</b> "+steptext );
//				$("#car"+carID+" .next").append( "<br><b>Next"+poly.GetIndexAtDistance(d)+" "+dirn.getRoute(0).getStep(stepnum).getPolylineIndex()+":</b> "+steptext );

				var stepdist = dirn.getRoute(0).getStep(stepnum-1).getDistance().meters;
				var steptime = dirn.getRoute(0).getStep(stepnum-1).getDuration().seconds;
				var stepspeed = ((stepdist/steptime) * 2.24).toFixed(0);
				step = stepspeed/2.5;

				speed = stepspeed +" mph";

				$("#car"+carID+" .speed").html( speed );

			} else {

			}

		} else {
			if (dirn.getRoute(0).getStep(stepnum).getPolylineIndex() < poly.GetIndexAtDistance(d)) {
				// document.getElementById("step").innerHTML = "<b>Next: Arrive at your destination</b>";

				$("#car"+carID+" .step").html( "<b>Next: Arrive at your destination</b>" );
//				$("#car"+carID+" .step").append( "<br><b>Next: Arrive at your destination</b>" );


			}
		}

		d += step;

		setTimeout(function () {
			animate();
		}, tick);

	}

}


if (GBrowserIsCompatible()) {

	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GMapTypeControl());
	map.setCenter(new GLatLng(0,0),2);

   
    
    var place_start_end = ['Ogorului, Oradea', 
                           'Traian Lalescu, Oradea', 
                           'Transilvaniei, Oradea', 
                           'Nufarul, Oradea',
                           'Alea Rogerius, Oradea',
                           'Cerbului, Oradea',
                           'Beius, Bihor'];
                           
            
            setInterval(function(){
                
                $.post("ajax.php",{
                    verificare_comenzi_active: 1
                },function(json_data,status){
                    //console.log(json_data);
                    //aici se intoarce format json 
                    //parsam si obtinem object
                    //console.log(json_data);
                    var jsonObject =  JSON.parse( json_data );
                    
                    if(jsonObject){
                        
                            var startpoint = jsonObject.location_start;
                		    var endpoint = jsonObject.location_end;
                            var carindex = jsonObject.id_taxi;
                            var id_order = jsonObject.Id;
                            var customer_name = jsonObject.customer_name;
                            var start_destination =jsonObject.location_start; 
                            var end_destination = jsonObject.location_end;
                            var total_km = jsonObject.total_km;
                            var customer_phone_nr = jsonObject.customer_phone_nr;
                            //var taxi_indicativ = jsonObject.    
                            
                            //console.log(jsonObject.location_start);
                            //console.log(jsonObject.location_end);
                            //console.log(jsonObject.id_taxi);
                            //console.log(jsonObject.Id);
              		    
                            directClass( startpoint, endpoint, 1, 10, carindex, customer_name, start_destination, end_destination, total_km, customer_phone_nr, id_order );
                            
                            console.log("------>"+carindex);
                            console.log("------>"+id_order);
                            
                            $.post("ajax.php",{
                                order_in_progress: 1,
                                id_taxi: carindex,
                                id_order: id_order
                            },function(data,status){
                               // console.log(data);
                                 if(data == "ok"){
                                   console.log('****** ORDER IN PROGRESS -- CarId:'+carindex+' -- Order No:'+id_order+'***************');   
                                                                 }
                            });
                            
                    }else{
                        console.log('No new order found in sistem!');
                    }
                    
                })
            
            
        }, 100)
        

}

var customers_lista = ['Popescu Stefan', 
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
                  'Bumbacului 34, Oradea',
                  'Traian Lalescu 28, Oradea',
                  'Nufarului 45, Oradea',
                  'Feldioarei 12, Oradea',
                  'Dragos Voda 12, Oradea',
                  'Cuza Voda 56, Oradea',
                  'Piata 1 Decembrie, Oradea',
                  'Matei Corvin 120, Oradea',
                  'Razboieni 24 , Oradea',
                  'Razboieni 34, Oradea',
                  'Podgoriei 35, Oradea'
                  ]; 
                  
                                        
console.log(customers_lista);
console.log(destination);


setInterval(function(){
    
    $.post("ajax.php",{
         get_taxi_drivers: 1
    },function(json_data,status){
        var jsonObject =  JSON.parse( json_data );
        //console.log(jsonObject);
        if(jsonObject){
            var destination_id_1 = 1 + Math.floor(Math.random() * 13);
            var destination_id_2 = 1 + Math.floor(Math.random() * 13);
            console.log('number_1: '+destination_id_1);
            console.log('number_2: '+destination_id_2);
            if(!destination_id_1 == destination_id_2){
              var id_taxi = jsonObject.Id;
              var id_company = jsonObject.id_company;
              
              var start_location = destination[destination_id_1];
              var end_location = destination[destination_id_2];
              
              console.log(start_location);
              console.log(end_location);
            }
            
            
             
            //console.log(id_company); 
            //console.log(id_taxi); 
        
        }else{
            console.log('No free taxy driver in the moment!');
        }
    });
    
}, 1000);


    //]]>
    </script>
    </span></div>

  </body>



</html>