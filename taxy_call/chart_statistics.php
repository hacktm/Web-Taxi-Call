<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<!-- <div id="container" style="height: 600px;width:400px;float:left;margin-left:12px;"></div> -->
<div id="container" style="height: 360px;width:400px;float:left;margin-left:6px;"></div>
<!-- <div id="data"></div> -->
<script>
      /*function setKey(key, value, targetObject) {
        var keys = key.split('.'), obj = targetObject || window, keyPart;
        while ((keyPart = keys.shift()) && keys.length) {
          obj = obj[keyPart];
        }
        obj[keyPart] = value;
      }
      function drawPieChart(data_info) {
          $('#container').highcharts({
            title: {
                text: 'Cash gain'
            },
            credits: {
                enabled: false
            },
            chart: {
                borderWidth: 0,
                marginLeft: 2,
                animation:false,
                height: 300,
                tooltip: { animation:true , pointFormat: '{series.name}: <b>{point.percentage}%</b>', percentageDecimals: 0 },
                type: 'pie',
                options3d: {
    				enabled: true,
                    alpha: 45,
                    beta: 0,
                }
            },
            plotOptions: {
                series: {
                    enableMouseTracking: false,
                    animation : false
                },
                pie: { depth: 25,allowPointSelect: false, cursor: 'pointer', dataLabels: { enabled: true, color: '#000000', connectorWidth: 1, connectorColor: '#000000', formatter: function() { return '<b>' + this.point.name + '</b>:<br/> ' + Math.round(this.percentage) + ' %'; } } }
            },
          series: [{
              type: 'pie',
              name: 'Cash gain ',
              data: data_info
          }]
        });
      }
      function updatePieChart(data_info_lng,array){
          var chart = $('#container').highcharts();
          var lng = chart.series[0].data.length;
          for(i=0;i<data_info_lng;i++) {
            chart.series[0].data[i].update(array[i]);
          }
      }
      function getLng() {
        $.post("ajax.php",{
          data_info_lng_request : 1
        },function(data,status){
          $('#data').html(data);
        });
      }
      var data_info;
      drawPieChart( [
                      ['City Taxi',   1],
                      ['Start Taxi',       1],
                      ['Hello Taxi', 1],
                      ['Fulger Taxi',    1]
                  ]);
      //Here initialize the chart.
      window.setInterval(function(){
        getLng();
        window.setTimeout(function(){
          $.post("ajax.php",{
            request_company_names : 1
          },function(data,status){
            var result = data.split(",");
            //Daca mergem cu un counter vom parcurge pana la pen-penultimul element al array-ului.
            var obj_to_post = new Object();
            obj_to_post.request_company_cash = 1;
            for(i=0;i<result.length-1;i++) {
              setKey('company'+Number(i+1),i+1,obj_to_post);
            }
            //console.log(obj_to_post);
            $.post("ajax.php",obj_to_post,function(data,status){
              //console.log(data);
                var array_req = [['Hello Taxi',1],['Fulger Taxi',0],['Start Taxi',3],['City Taxi',4]]; // Here is the array we get on post.
                var data_info_lng = $('#data').text();
                data_info = [];
                for(counter = 0; counter<data_info_lng; counter++) {
                  if(array_req[counter][1]!=0) {
                    data_info.push(array_req[counter]);
                  }
                }
                drawPieChart(data_info);
                updatePieChart(data_info.lng,data_info);
            });
          });
        },1000);
      },1500);*/
      $('#container').highcharts({
        chart: {
            renderTo: 'container',
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50,
                viewDistance: 25
                //tooltip: { followTouchMove: true }
                //tooltip: { animation:true , pointFormat: '{series.name}: <b>{point.percentage}%</b>', percentageDecimals: 0 }
            }
        },
        title: {
            text: 'Active drivers'
        },
        credits: {
          enabled: false
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b><br/>',
            valueSuffix: ' %',
            shared: true,
            valueDecimals: 1
        },
        xAxis: {
            categories: ['Fulger Taxi', 'City Taxi', 'Start Taxi', 'Hello Taxi']
        },
        plotOptions: {
            column: {
                depth: 25
            }
            /*series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                          
                        }
                    }
                }
            },*/
          /*series: {
              dataLabels: {
                  formatter: function() {
                      return '<b>' + this.point.name + '</b>: ' + this.percentage.toFixed(2) + ' %';
                  }
              }
          }*/
        },
        series: [{
            data: [["Fulger Taxi",1],["City Taxi",1],["Start Taxi",1],["Hello Taxi",1]],
            name : 'Percentage '
        }]
      });
      var j = 100;
      setInterval(function(){
        j++;
        if(j>120) {
          j/=100;
        }
        var chart = $('#container').highcharts();
        chart.series[0].data[0].update(j);
        chart.series[0].data[1].update(j+3/2);
        chart.series[0].data[2].update(j/21+30);
        chart.series[0].data[3].update(j/3+40);
      },100);
</script>