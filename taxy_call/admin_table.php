<?php include('connect_db.php');
  if(isset($_POST['create_table'])) {
    //$array = array();
    //Data primit de browser va fi un object pe care il vom creea aici, atasand fiecare data in acesta.
    $select_order = mysqli_query($con,"SELECT *FROM `orders` WHERE `active` = '0'");
    $i = 0;
    while($row_order = mysqli_fetch_array($select_order)) { $i++;
      //array_push($array,array($row_order["location_start"],$row_order["location_end"]));
      /*echo "Location start -> ".$row_order["location_start"]."\n";
      echo "Location end -> ".$row_order["location_end"]."\n";*/
      ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row_order['location_start'];?></td>
        <td><?php echo $row_order['location_end'];?></td>
        <td><?php echo $row_order['total_km']; ?></td>
      </tr>
      <?php
    }
  }
  if(isset($_POST['get_nr_rows'])) {
    $select_order = mysqli_query($con,"SELECT *FROM `orders` WHERE `active` = '0'");
    echo mysqli_num_rows($select_order);
  }
  if(isset($_POST['order_progress'])) {
    //mysqli($con,"UPDATE `orders` SET ``");
    //We here decrement util 0 when we delete the order.
  }
?>