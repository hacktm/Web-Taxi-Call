<?php include('header.php');
   if(!$_SESSION['logat'] == 1){header('location:  login_interface.php');}
   include('menu_admin_interface.php');
   //var_dump($_SESSION);
   ?>
   
   <?php
    $id_order = secure_injection($con,$_GET['id_order']); 
    $select_taxi_order = mysqli_query($con,"SELECT *FROM `orders` WHERE `Id` = '".$id_order."'");
    $row_taxi_order = mysqli_fetch_assoc($select_taxi_order);
   ?>
   
   <table class='table table-striped'>
    <tbody>
      <tr>
        <td><?php echo $row_taxi_order['customer_name']; ?></td>
        <td><?php echo $row_taxi_order['customer_phone_nr']; ?></td>
        <td><?php echo $row_taxi_order['total_km']; ?></td>
        <td><?php echo $row_taxi_order['location_start']; ?></td>
        <td><?php echo $row_taxi_order['location_end']; ?></td>
        <td><?php echo $row_taxi_order['time']; ?></td>
        <td><?php echo $row_taxi_order['ip_adress']; ?></td>
        <td><?php echo $row_taxi_order['comment']; ?></td>
        <td><button>End Order</button></td>
      </tr>
    </tbody>
   </table>
   
<?php include('footer.php'); ?>