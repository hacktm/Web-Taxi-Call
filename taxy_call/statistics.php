<script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1', {'packages':['corechart']});
      function drawPieChart(data_ok) {
        
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(data_ok);

        // Set chart options
        var options = {'title':'Total income today by all company',
                       'width':400,
                       'height':300,
                       is3D : true};

        // Instantiate and draw our chart, passing in some options.
        var pie = new google.visualization.PieChart(document.getElementById('pie'));
        //var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
        pie.draw(data, options);
        //chart1.draw(data, options);
      }
      google.load("visualization", "1.0", {packages:["barchart"]});
      function drawBarChart(data_ok) {
        var data = google.visualization.arrayToDataTable([
          ['Company', 'Working drivers'],
          <?php 
            for($i=0;$i<4;$i++) {
              if($i!=3) {
              ?>
              data_ok[<?php echo $i; ?>],
              <?php
              }
              else {?>
                data_ok[<?php echo $i; ?>]
              <?php
              }
            }
          ?>
        ]);

        var chart = new google.visualization.BarChart(document.getElementById('bar'));
        chart.draw(data, {width: 400, height: 240, is3D: true, title: 'Company Performance'});
      }
      setInterval(function(){
         
          $.post("ajax.php",{
            total_income_company: 1
              },function(data, status){
                  var data_ok =  $.parseJSON( data );
                   // Set a callback to run when the Google Visualization API is loaded.
                   google.setOnLoadCallback(drawPieChart(data_ok));
                   
              });
          
      }, 2000);
      
      setInterval(function(){
        $.post("ajax.php",{
           total_drivers_in_progress : 1
         },function(data,status){
           var data_ok = $.parseJSON( data );
           google.setOnLoadCallback(drawBarChart(data_ok));
         });
      },2000);
      function drawVisualization() {
      $.post("ajax.php",{
        orders_ended : 1
      },function(data_got,status){
        var data_got = $.parseJSON(data_got);
        console.log(data_got);
        var data = google.visualization.arrayToDataTable([
        ['Company', 'Orders Complete' ],
        data_got[0],
        data_got[1],
        data_got[2],
        data_got[3]
      ]);
    
      var options = {
        title : 'Orders Completed',
        vAxis: {title: "Value"},
        hAxis: {title: "Companies"},
        seriesType: "bars",
        series: {5: {type: "line"}}
      };
    
      var chart = new google.visualization.ComboChart(document.getElementById('combo'));
      chart.draw(data, options);
      });
    }
    setInterval(google.setOnLoadCallback(drawVisualization),2000);
    </script>
<style>
#chart_div {
    margin-top: 0;
    float:left;
}
/*#chart_div1 {
    margin-top: 0;
    float:left;
}*/
</style>
<div id="pie" style="float: left;"></div>
<div id="bar" style="float: left;"></div>
<div id="combo" style="float: left;"></div>