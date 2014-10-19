<?php //include('function.php');

function sum_km($con, $id_taxi){
  $select_km_taxy = mysqli_query($con, "SELECT SUM(total_km) as sum_total_km FROM `orders` WHERE `id_taxi` = '".$id_taxi."'");
  $row_km_taxy = mysqli_fetch_assoc($select_km_taxy);
  
   if(!$row_km_taxy['sum_total_km'] == 0){
    $total_km = $row_km_taxy['sum_total_km'];
   }else{
    $total_km = 0;
   }
  
  return $total_km;
}

function get_total_fluid($con, $id_taxi){
  $select_fluid = mysqli_query($con, "SELECT * FROM `taxi_drivers` WHERE `Id` = '".$id_taxi."'");
  $row_fluid = mysqli_fetch_assoc($select_fluid);
  $consumer = $row_fluid['consumer'];

  $select_taxy_km = mysqli_query($con, "SELECT SUM(total_km) AS total_km_taxy FROM `orders` WHERE `id_taxi` = '".$id_taxi."'");
  $row_taxy_km = mysqli_fetch_assoc($select_taxy_km);
  $total_km = $row_taxy_km['total_km_taxy'];
  
  $cost_fuent = round($total_km * $consumer / 100 * 6.34, 2);
  return $cost_fuent;
}

function total_incoming($con, $id_taxi){
  $select_taxi = mysqli_query($con, "SELECT * FROM `taxi_drivers` WHERE `Id` = '".$id_taxi."'");
  $row_taxi = mysqli_fetch_assoc($select_taxi);
  
  $select_company = mysqli_query($con, "SELECT * FROM `taxi_comp` WHERE `Id` = '".$row_taxi['id_company']."'");
  $row_company = mysqli_fetch_assoc($select_company);
  
  $select_taxy_km = mysqli_query($con, "SELECT SUM(total_km) AS total_km_taxy FROM `orders` WHERE `id_taxi` = '".$id_taxi."'");
  $row_taxy_km = mysqli_fetch_assoc($select_taxy_km);
  $total_km = $row_taxy_km['total_km_taxy'];

  $total_incoming = round($total_km * $row_company['day_price_km'], 2);
  
  return $total_incoming;
}
?>
<table data-toggle="table" class='table table-striped'>
  <tr>
    <td>Name Company</td>
    <td>Name and ind Taxy Drivers</td>
    <td>Total Income</td>
    <td>Cost of Fluel</td>
    <td>Profit</td>
    <td>Total km </td>
  </tr>
<?php 
$select_company = mysqli_query($con, "SELECT * FROM `taxi_comp`");
while($row_company = mysqli_fetch_array($select_company)){
  
  ?>
  <tr>
    <td><?php echo $row_company['company_name']; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <?php 
  $select_drivers = mysqli_query($con, "SELECT * FROM `taxi_drivers` WHERE `id_company` = '".$row_company['Id']."'");
  while($row_drivers = mysqli_fetch_array($select_drivers)){
    $total_km_drivers = sum_km($con, $row_drivers['Id']);
    $total_fluid = get_total_fluid($con, $row_drivers['Id']);
    $total_income = total_incoming($con, $row_drivers['Id']);
    $profit = $total_income - $total_fluid;
  ?>
  <tr>
    <td></td>
    <td><?php echo $row_drivers['name']; ?> / <?php echo $row_drivers['indicative']; ?></td>
    <td><?php echo $total_income; ?> Lei</td>
    <td><?php echo $total_fluid; ?> Lei</td>
    <td><?php echo $profit; ?> Lei</td>
    <td><?php echo $total_km_drivers; ?> Km</td>
  </tr>
  <?php 
  }
}
?>
</table>
<?php
 
 ?>