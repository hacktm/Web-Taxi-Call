<?php include('header.php');
   if(!$_SESSION['logat'] == 1){header('location:  login_interface.php');}
   include('menu_admin_interface.php');
   //var_dump($_SESSION);
   ?>
   <!--<style>
    body {
      background : #CAE2E3;
    }
   </style> -->
   <div class="jumbotron">
        <h2 style="text-align: center;">Welcome to the admin interface !</h2>
        <br />
        <br />
    
        <a href="add_taxi.php"><div class="container_dashbord1">Add Taxy Drive</div></a>
        <a href="manage_taxi.php"><div class="container_dashbord1">Manage Taxy Drive</div></a>
        <a href="live_maps.php" target="_blank"><div class="container_dashbord2">Live Maps</div></a>
        <a href="live_demo.php" target="_blank"><div class="container_dashbord2">Live Demo</div></a>
        <!--<div class="container_dashbord"></div>
        <div class="container_dashbord"></div>
        <div class="container_dashbord"></div>
        <div class="container_dashbord"></div> -->
        
        <div class="clear"></div>
        <div>
        <h3>All Company Statistics</h3>
        <?php include('table_statistics.php'); ?>
        </div>
    </div> 
    <h1>Statistics:</h1>
    <!--<table style="float:left;" border="2">
      <thead>
        <tr>
          <th>Nr. Order</th>
          <th>Start location</th>
          <th>End location</th>
          <th>Km left</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <script>
      /*window.setInterval(function(){
          $.post("admin_table.php",{
            create_table : 1
          },function(data,status){
            //Here we recieve an object.
            $("tbody").html(data);
          });
          $.post("admin_table.php",{
             order_progress : 1
          },function(data,status){});
      },2000);*/
    </script> -->
  <?php include('statistics.php'); ?>  
    
<?php include('footer.php'); ?>