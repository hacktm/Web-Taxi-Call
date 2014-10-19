<?php include('function.php');

if(isset($_POST['get_coo'])){
    $Address = $_POST['adress'];
$Address = urlencode($Address);
$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
$xml = simplexml_load_file($request_url) or die("url not loading");
$status = $xml->status;
  if ($status=="OK") {
      $Lat = $xml->result->geometry->location->lat;
      $Lon = $xml->result->geometry->location->lng;
      echo $LatLng = "$Lat,$Lon";
      
  }

}

if(isset($_POST['send_order'])) {
    $name = secure_injection($con,$_POST['name']);
    $phone = secure_injection($con,$_POST['phone']);
    $comment = secure_injection($con,$_POST['comment']);
    $id_company = secure_injection($con,$_POST['id_company']);
    $long_lat_start = secure_injection($con,$_POST['long_lat_start']);
    $long_lat_end = secure_injection($con,$_POST['long_lat_end']);
    $total_km = secure_injection($con,$_POST['total_km']);
    $start = secure_injection($con,$_POST['start']);
    $end = secure_injection($con,$_POST['end']);
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $ip = getClientIP();
    
    $query = "INSERT INTO `orders`  (`customer_name`,
                                     `customer_phone_nr`,
                                     `long_lat_start`,
                                     `long_lat_end`,
                                     `total_km`,
                                     `location_start`,
                                     `location_end`,
                                     `id_taxi`,
                                     `id_comp`,
                                     `active`,
                                     `date`,
                                     `time`,
                                     `ip_adress`,
                                     `comment`,
                                     `in_progress`)
                                     VALUE 
                                     ('".$name."',
                                      '".$phone."', 
                                      '".$long_lat_start."', 
                                      '".$long_lat_end."', 
                                      '".$total_km."', 
                                      '".$start."',
                                      '".$end."', 
                                      '0',
                                      '".$id_company."',
                                      '1',
                                      '".$date."', 
                                      '".$time."',
                                      '".$ip."', 
                                      '".$comment."',
                                      '0')";
    
    if(mysqli_query($con, $query)){
        echo "Congratulation ! The order has been sent! Please wait for the taxi response!";
    }else{
        echo "The order couldn't be sent ! Please try again, later !";
    }
}

if(isset($_POST['taxi_response_check'])) {
    
        $ip = getClientIP();
        $select_response = mysqli_query($con,"SELECT *FROM `orders` WHERE `ip_adress` = '".$ip."' AND `active` = '0' AND `in_progress`= '1'");
        $row_response = mysqli_fetch_array($select_response);
        if(!$row_response['id_taxi'] == null){
            $select_taxi = mysqli_query($con,"SELECT * FROM `taxi_drivers` WHERE `Id` = '".$row_response['id_taxi']."'");
            $row_taxi = mysqli_fetch_assoc($select_taxi);
      ?>
      <table border="2" class='table table-striped'>
      <tr>
        <td>Indicator</td>
        <td>Aproximative Time</td>
        <td>Car</td>
        <td>Driver</td>
      </tr>
      <tr>
        <td><?php echo $row_taxi['indicative']; ?></td>
        <td>3 Minutes</td>
        <td><?php echo $row_taxi['drive']; ?></td>
        <td><?php echo $row_taxi['name']; ?></td>
      </tr>
      </table>
      <?php }else{
        
        echo "Please wait until the order will be retrived !";
        
      } 
}


    if(isset($_POST['check_command_taxi'])) {
        $id_company = secure_injection($con,$_POST['id_company']);
        echo "List of active orders for your company :";
        echo "<br />";
        echo "<table class='table table-striped'>";
        $i = 0;
        $select_taxi_command = mysqli_query($con,"SELECT * FROM `orders` WHERE `id_comp` = '".$id_company."' AND `active` = '1' AND `in_progress` = '0' ");
        while($row_taxi_command = mysqli_fetch_array($select_taxi_command)) { $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row_taxi_command['customer_name']; ?></td>
                <td><?php echo $row_taxi_command['customer_phone_nr']; ?></td>
                <td><?php echo $row_taxi_command['total_km']; ?> km</td>
                <td><?php echo $row_taxi_command['location_start']; ?></td>
                <td><?php echo $row_taxi_command['location_end']; ?></td>
                <td><?php echo $row_taxi_command['time']; ?></td>
                <td><?php echo $row_taxi_command['comment']; ?></td>
                <td><button onclick="command_retrieve(<?php echo $row_taxi_command['Id']; ?>,<?php echo $_SESSION['drivers']['Id']; ?>)">Retrieve Command</button></td>
                <td><button onclick="show_maps('<?php echo $row_taxi_command['long_lat_start']; ?>','<?php echo $row_taxi_command['location_start']; ?>','<?php echo $row_taxi_command['location_end']; ?>')">Show in maps</button></td> 
            </tr>
            <?php
        } 
        echo "</table>";
    }
    
    if(isset($_POST['command_retrieve'])) {
        $array = array();
        $id_order = secure_injection($con,$_POST['id_order']);
        $id_taxi = secure_injection($con,$_POST['id_taxi']);
        if(mysqli_query($con,"UPDATE `orders` SET `id_taxi` = '".$id_taxi."', `active` = '0',`in_progress` = '1' WHERE `Id` = '".$id_order."'")) {
          echo $id_order;
        }
    }
    
    if(isset($_POST['add_taxi_driver'])) {
      $id_company = secure_injection($con,$_POST['id_company']);
      $name = secure_injection($con,$_POST['name']);
      $phone_number = secure_injection($con,$_POST['phone_number']);
      $indicative = secure_injection($con,$_POST['indicative']);
      $drive = secure_injection($con,$_POST['drive']);
      $active = secure_injection($con,$_POST['active']);
      $total_km = secure_injection($con,$_POST['total_km']);
      $total_money = secure_injection($con,$_POST['total_money']);
      $username = secure_injection($con,$_POST['username']);
      $password = secure_injection($con,$_POST['password']);
      mysqli_query($con,"INSERT INTO `taxi_drivers` (`id_company`, `name`, `phone_number` , `indicative` , `drive` , `active` , `total_km` , `total_money` , `username` , `password`)
                                      VALUES ('".$id_company."', '".$name."','".$phone_number."','".$indicative."','".$drive."','".$active."','".$total_km."','".$total_money."','".$username."','".$password."')");
    }
    
    /*if(isset($_POST['pie_chart_data'])) {
      $select_taxi_drivers = mysqli_query($con,"SELECT *FROM `taxi_drivers`");
      $num_taxi_drivers = mysql_num_rows($select_taxi_drivers);
      echo "$num_taxi_drivers Rows\n";
    }*/
    
    if(isset($_POST['data_info_lng_request'])) {
      $select_taxi_drivers = mysqli_query($con,"SELECT *FROM `taxi_comp`");
      $num_taxi_drivers = mysqli_num_rows($select_taxi_drivers);
      echo $num_taxi_drivers;
    }
    
    if(isset($_POST['request_company_names'])) {
      $select_comp_names = mysqli_query($con,"SELECT *FROM `taxi_comp`");
      while($row_taxi_comp = mysqli_fetch_array($select_comp_names)) {
        echo $row_taxi_comp['company_name'].',';
      }
    }
    
    if(isset($_POST['request_company_cash'])) {
      $back_array = array();
      foreach ($_POST as $key => $val) {
          //echo "$key = $val\n";
          $select_taxi_cmp = mysqli_query($con,"SELECT *FROM `taxi_drivers` WHERE `id_company` = $val");
          $sum_cash_percmp = 0;
          while($row_taxi_cmp = mysqli_fetch_array($select_taxi_cmp)) {
            $sum_cash_percmp+=$row_taxi_cmp['total_money'];
          }
          $back_array[] = array(1 => $val, 2 => $sum_cash_percmp);
      }
      var_dump( $back_array );
    }
    
    
    //select comenzi noi si neterminate si encode_json! active 1 si in_progress 0
    if(isset($_POST['verificare_comenzi_active'])){
       $select_orders = mysqli_query($con, "SELECT * FROM `orders` WHERE `active` = '1' AND `in_progress` = '0'");
       $row_orders = mysqli_fetch_assoc($select_orders);
       echo json_encode($row_orders); 
    }
    //in desfasurare atunci active este 0 si in_progres e 1 
    if(isset($_POST['order_in_progress'])){
        $id_taxi = secure_injection($con, $_POST['id_taxi']);
        $id_order = secure_injection($con, $_POST['id_order']);
        
        $query_1 = "UPDATE `orders` SET `in_progress` = '1', `active` = '0' WHERE `Id` = '".$id_order."'";
        $query_2 = "UPDATE `taxi_drivers` SET `work` = '1' WHERE `Id` = '".$id_taxi."'";
        
        if(mysqli_query($con,$query_1) && mysqli_query($con,$query_2)){
            echo "ok";
        }
    }
    //daca a terminat cursa active devine 0 si in_progress 0
    if(isset($_POST['end_order_taxi'])){
        
        $id_taxi = secure_injection($con, $_POST['id_taxi']);
        $order_id = secure_injection($con, $_POST['id_order']);
        
        $query_1 = "UPDATE `orders` SET `active` = '0', `in_progress` = '0' WHERE `Id` = '".$order_id."'";
        $query_2 = "UPDATE `taxi_drivers` SET `work` = '0' WHERE `Id` = '".$id_taxi."'";
        
        if(mysqli_query($con, $query_1) && mysqli_query($con, $query_2)){
            echo "ok";
        }
    }
    
    if(isset($_POST['get_taxi_drivers'])){
        
        $select_taxi_drivers = mysqli_query($con, "SELECT * FROM `taxi_drivers` WHERE `active` = '1' AND `work` = '0'");
        $row_taxi_drivers = mysqli_fetch_assoc($select_taxi_drivers);
        
        echo json_encode($row_taxi_drivers); 
    }
    
    if(isset($_POST['send_auto_order'])){
      $km = secure_injection($con, $_POST['km']);
      $start_location = secure_injection($con, $_POST['start_location']);
      $end_location = secure_injection($con, $_POST['end_location']);
      $id_company = secure_injection($con, $_POST['id_company']);
      $id_taxi = secure_injection($con, $_POST['id_taxi']);
      $customers = secure_injection($con, $_POST['customers']);
      $lat_lng_start = secure_injection($con, $_POST['lat_lng_start']);
      $lat_lng_end = secure_injection($con, $_POST['lat_lng_end']);
      $date = date('Y-m-d');
      $time = date('H:i:s');
      $ip = getClientIP();
      $phone_number = "1111111111";
      $comment = "Auto generated Order!";
      
      $select_order = mysqli_query($con, "SELECT * FROM `orders` WHERE `customer_name` = '".$customers."' AND `active` = '0' AND `in_progress` = '1'");
      $num_row_orders = mysqli_num_rows($select_order);
      
      if($num_row_orders == null){
        $query = "INSERT INTO `orders` (`customer_name`,
                                        `customer_phone_nr`,
                                        `long_lat_start`,
                                        `long_lat_end`,
                                        `total_km`,
                                        `location_start`,
                                        `location_end`,
                                        `id_taxi`,
                                        `id_comp`,
                                        `active`,
                                        `date`,
                                        `time`,
                                        `ip_adress`,
                                        `comment`,
                                        `in_progress`) 
                                 VALUE 
                                 ('".$customers."',
                                  '".$phone_number."',
                                  '".$lat_lng_start."',
                                  '".$lat_lng_end."',
                                  '".$km."',
                                  '".$start_location."',
                                  '".$end_location."',
                                  '".$id_taxi."',
                                  '".$id_company."',
                                  '1',
                                  '".$date."',
                                  '".$time."',
                                  '".$ip."',
                                  '".$comment."',
                                  '0')";
             //echo $query; 
             
             if(mysqli_query($con, $query)){
                  echo "The Order has ben recived succesfull!";
             }                    
        
      }else{
        echo "Acest user dej este intr-o comanda in desfasurare!";
      }
      
    }
    
    //live orders report
    if(isset($_POST['live_order_report'])){
       echo"<h2>List of in progress orders!</h2>";
       echo "<table border='1'>";
       ?>
       <tr>
         <td>CRT</td>
         <td>Company</td>
         <td>Drivers Name</td>
         <td>Indicative</td>
         <td>Customer name</td>
         <td>Location Start</td>
         <td>Location End</td>
         <td>Total KM</td>
         <td>Total Price per Order</td>
         <td>Total fuel consumed per order</td>
         <td>Date</td>
         <td>Time</td>
       </tr>
       <?php 
       
        $i = 0;
        $select_live_orders = mysqli_query($con, "SELECT * FROM `orders` WHERE `active` = '0' AND `In_progress` = '1'");
        while($row_live_orders = mysqli_fetch_array($select_live_orders)){$i++;
            $select_company = mysqli_query($con, "SELECT * FROM `taxi_comp` WHERE `Id` = '".$row_live_orders['id_comp']."'");
            $row_company = mysqli_fetch_assoc($select_company);
            $select_drivers = mysqli_query($con, "SELECT * FROM `taxi_drivers` WHERE `Id` = '".$row_live_orders['id_taxi']."'");
            $row_drivers = mysqli_fetch_assoc($select_drivers);
            
            $total_price = $row_live_orders['total_km'] * $row_company['day_price_km'] + $row_company['day_price_km'];
            $consumer_order = round($row_live_orders['total_km'] * $row_drivers['consumer'] / 100, 2);
            $total_price_fluel = round($consumer_order * 6,34 ,2);
            
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row_company['company_name']; ?></td>
              <td><?php echo $row_drivers['name']; ?></td>
              <td><?php echo $row_drivers['indicative']; ?></td>
              <td><?php echo $row_live_orders['customer_name']; ?></td>
              <td><?php echo $row_live_orders['location_start']; ?></td>
              <td><?php echo $row_live_orders['location_end']; ?></td>
              <td><?php echo $row_live_orders['total_km']; ?> Km</td>
              <td><?php echo $total_price; ?> Lei</td>
              <td><?php echo $consumer_order; ?> L / <?php echo $total_price_fluel; ?> Lei</td>
              <td><?php echo $row_live_orders['date']; ?></td>
              <td><?php echo $row_live_orders['time']; ?></td>
            </tr>
            <?php 
        }
       echo "</table>";
    }
    
    if(isset($_POST['total_income_company'])){
        
        $array_sum_orders = array();
        
        $today = date('Y-m-d');
        $select_company = mysqli_query($con, "SELECT * FROM `taxi_comp` ");
        while($row_company = mysqli_fetch_array($select_company)){
            
            $select_company_orders = mysqli_query($con, "SELECT SUM(total_km) as total_km_sum FROM `orders` WHERE `date` = '".$today."' AND `active` = '0' AND `in_progress` = '0'");
            $row_company_orders = mysqli_fetch_assoc($select_company_orders);
            
            $total_company_money = round($row_company_orders['total_km_sum'] * $row_company['day_price_km'], 2);
            $array_sum_orders[] = array($row_company['company_name']."  ".$total_company_money." Lei" => $total_company_money);
        }
         $json = json_encode($array_sum_orders);
         echo str_replace(array('{"', '":', '}'), array('["', '", ', ']'), $json);
    }
    if(isset($_POST['total_drivers_in_progress'])) {
      $working_drivers = array();
      $select_taxi_cmp = mysqli_query($con,"SELECT *FROM `taxi_comp` WHERE `active` = '1'");
      while($row_taxi_cmp = mysqli_fetch_array($select_taxi_cmp)) {
        
        $id_cmp = $row_taxi_cmp['Id'];
        $company_name = $row_taxi_cmp['company_name'];
        
        $select_working_drivers = mysqli_query($con,"SELECT * FROM `taxi_drivers` WHERE `work` = '1' AND `id_company` = '$id_cmp'");
        $num_working_drivers = mysqli_num_rows($select_working_drivers);
        
        $working_drivers[] = array($company_name , $num_working_drivers);
      }
      $json_working_drivers = json_encode($working_drivers);
      echo str_replace(array('{"', '":', '}'), array('["', '", ', ']'), $json_working_drivers);
    }
    if(isset($_POST['orders_ended'])) {
      if(isset($_POST['orders_ended'])) {
        $complete_orders = array();
        $select_taxi_cmp = mysqli_query($con,"SELECT *FROM `taxi_comp` WHERE `active` = '1'");
        while($row_taxi_cmp = mysqli_fetch_array($select_taxi_cmp)) {
          
          $id_cmp = $row_taxi_cmp['Id'];
          $company_name = $row_taxi_cmp['company_name'];
          
          $select_complete_orders = mysqli_query($con,"SELECT * FROM `orders` WHERE `active` = '0' AND `in_progress` = '0'");
          $num_complete_orders = mysqli_num_rows($select_complete_orders);
          
          $complete_orders[] = array($company_name , $num_complete_orders);
        }
        $json_complete_orders = json_encode($complete_orders);
        echo str_replace(array('{"', '":', '}'), array('["', '", ', ']'), $json_complete_orders);
      }
    }
    if(isset($_POST['management_table'])) {
      ?>
      <thead>
          <tr>
            <th>ID</th>
            <th>Company ID</th>
            <th>Name</th>
            <th>Phone number</th>
            <th>Indicative</th>
            <th>Car</th>
            <th>Active</th>
            <th>Total km</th>
            <th>Total money</th>
            <th>Username</th>
            <th>Password</th>
            <th colspan="2">Settings</th>
          </tr>
      </thead>
      <tbody>
      <?php
      $i = 0;
      $select_taxi_driver = mysqli_query($con,"SELECT *FROM `taxi_drivers`");
      while($row_taxi_driver = mysqli_fetch_array($select_taxi_driver)) { $i++;
        ?>
        <tr id="<?php echo 'row'.$i; ?>">
          <td id="<?php echo 'driver_id'.$i; ?>" contenteditable="false"><?php echo $row_taxi_driver['Id']; ?></td>
          <td id="<?php echo 'company_id'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['id_company']; ?></td>
          <td id="<?php echo 'driver_name'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['name']; ?></td>
          <td id="<?php echo 'phone'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['phone_number']; ?></td>
          <td id="<?php echo 'indicative'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['indicative']; ?></td>
          <td id="<?php echo 'car'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['drive']; ?></td>
          <td id="<?php echo 'activity'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['active']; ?></td>
          <td id="<?php echo 'total_km'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['total_km']; ?></td>
          <td id="<?php echo 'total_money'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['total_money']; ?></td>
          <td id="<?php echo 'username'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['username']; ?></td>
          <td id="<?php echo 'password'.$i; ?>" contenteditable="true"><?php echo $row_taxi_driver['password']; ?></td>
          <td><input id="<?php echo 'update'.$i; ?>" type="button" value="Update"/></td>
          <td><input id="<?php echo 'delete'.$i; ?>" type="button" value="Delete"/></td>
        </tr>
        <?php
      }
      ?>
      </tbody>
      <?php
    }
    
    if(isset($_POST['update_row'])) {
      $row_index = secure_injection($con,$_POST['row_index']);
      $driver_id = secure_injection($con,$_POST['driver_id']);
      $company_id = secure_injection($con,$_POST['company_id']);
      $driver_name = secure_injection($con,$_POST['driver_name']);
      $phone = secure_injection($con,$_POST['phone']);
      $indicative = secure_injection($con,$_POST['indicative']);
      $car = secure_injection($con,$_POST['car']);
      $total_km  = secure_injection($con,$_POST['total_km']);
      $total_money = secure_injection($con,$_POST['total_money']);
      $username = secure_injection($con,$_POST['username']);
      $password = secure_injection($con,$_POST['password']);
      $query = mysqli_query($con,"UPDATE `taxi_drivers` SET `id_company` = '$company_id' , 
                                                    `name` = '$driver_name',
                                                    `phone_number` = '$phone',
                                                    `indicative` = '$indicative',
                                                    `drive` = '$car',
                                                    `total_km` = '$total_km',
                                                    `total_money` = '$total_money',
                                                    `username` = '$username',
                                                    `password` = '$password' WHERE `Id` ='$row_index'");
      
      if($query) {
        echo "Column Updated !";
      } else {
        echo "Request Error !";
      }
    }
    
    if(isset($_POST['delete_row'])) {
      $row_index = $_POST['row_index'];
      $query = mysqli_query($con,"DELETE FROM `taxi_drivers` WHERE `Id` = '$row_index'");
      if($query) {
        echo "Column Deleted !";
      } else {
        echo "Request Error !";
      }
    }
    
    if(isset($_POST['add_report'])) {
      $report = $_POST['report'];
      $name = $_POST['name'];
      $query = mysqli_query($con,"INSERT INTO `reports` (`report`,`name_driver`) VALUES('$report','$name')");
      if($query) {
        echo 'Report added successfully !';
      } else {
        echo 'Try again !';
      }
    }
    
?>