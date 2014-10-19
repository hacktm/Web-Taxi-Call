
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!--
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
-->
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAi_x03rBPvcUzObU_OU5Z_RRMrZ4ZiepwBPC13G1CO0mIcOaHJBSF-jlBQxmGDKmcezkCQdycMczfaQ" type="text/javascript"></script>
    <script src="epoly.js" type="text/javascript"></script>
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

     <form onsubmit="start();return false">

      Enter start and end addresses.<br />

	 <strong> This example journey takes us from Patrick's St, Cork, Ireland to The Square, Blarney, Cork, Ireland.</strong><br />

	  Based on Google Maps Latitude, Longitude... just press the start button<br />

      <input type="text" size="80" maxlength="200" id="startpoint" value="" /><br />

      <input type="text" size="80" maxlength="200" id="endpoint" value="" /><br />

<!-- <input type="text" size="80" maxlength="200" id="startpoint" value="51.942638,-7.858014" /><br>

      <input type="text" size="80" maxlength="200" id="endpoint" value="52.009586,-7.912860" /><br> -->

      <input type="submit" value="Start"  />
     </form>
    </div>



    <div id="map" style="width: 100%; height: 400px"></div>

<table id="carsdata" width="100%">
</table>

<!--
    <div class="style1" id="step">&nbsp;</div>
    <div class="style1" id="distance">Miles: 0.00</div>
-->

<script type="text/javascript">

//<![CDATA[


function directClass( startpoint, endpoint, stepDefault, tick, carID ) {

//  var step = 50; // metres
//  var tick = 10; // milliseconds
	var eol;
	var poly;
	var car = new GIcon();
	car.image="car.png"
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

$('#carsdata').append('<tr id="car'+carID+'" valign="top">'+
'<td width="20%" class="step"></td>'+
'<td width="10%" class="distance"></td>'+
'<td width="10%" class="speed"></td>'+
'<td width="60%" class="next"></td></tr>'
);
//    <div class="style1" id="step">&nbsp;</div>
//    <div class="style1" id="distance">Miles: 0.00</div>
  
	function animate() {


		if ( d > eol ) {
			$("#car"+carID+" .step").html('<b>Completed</b>');
			//$("#car"+carID+" .step").append( '<br><b>Completed</b>' );

			$("#car"+carID+" .distance").html("Miles: "+(d/1609.344).toFixed(2));

//			document.getElementById("step").innerHTML = "<b>Trip completed</b>";
//			document.getElementById("distance").innerHTML =  "Miles: "+(d/1609.344).toFixed(2);
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
// console.log(q);

		// document.getElementById("distance").innerHTML =  "Miles: "+(d/1609.344).toFixed(2)+speed;
		$("#car"+carID+" .distance").html("Miles: "+(d/1609.344).toFixed(2)+speed);

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

var carindex = 1;
    
    setInterval(function(){
       
        var rand_num_1 = 1 + Math.floor(Math.random() * 7);
        var rand_num_2 = 1 + Math.floor(Math.random() * 7);
    
	/*
	 var place = [
	         [place_start_end[rand_num_1], place_start_end[rand_num_2], 100, 1000]
	 	];
	 */
     
     var place = [['Ogorului, Oradea','Traian Lalescu, Oradea',1, 10]];
      

    var place_length = place.length;

	for(i=0; i<place_length; i++) {
		var startpoint = place[i][0];
		var endpoint = place[i][1];

var a = Math.floor(Math.random() * 7)
do {
  var b = Math.floor(Math.random() * 7)
} while (a==b);
var startpoint = place_start_end[ a ];
var endpoint = place_start_end[ b ];
carindex++;
		directClass( startpoint, endpoint, 1, 10, carindex );
	}
    
}, 10000)
        

}

    //]]>
    </script>
    </span></div>

  </body>



</html>