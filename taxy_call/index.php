<?php include('header.php'); ?>
<?php include('menu.php'); ?>
<div style="width: 100%; height: 60%;" id="harta"></div>
<div id="message" style="color: orange; margin-left:5%; font-weight: bold; margin-top:1.5%;"></div>
<hr id="sep_line" style="display: none;"/>
<div id="total_km" style="display: none;"></div>
<div id="start_long_lat" style=""></div>
<div id="end_long_lat" style=""></div>
<audio id="audiotag1" src="sound/sound_respons.mp3" preload="auto"></audio>

<table data-toggle="table" class='table table-striped' style="display: none;" id="table_taxi">
    <thead>
        <tr>
            <th data-field="nr">Nr</th>
            <th data-field="company_name">Company Name</th>
            <th data-field="logo">Logo</th>
            <th data-field="price_km_day">Day Price/km</th>
            <th data-field="price_km_night">Night Price/km</th>
            <th data-field="price_rout">Rout Price</th>
            <th data-field="order">Order</th>
        </tr>
    </thead>
    <tbody>
      <?php $i = 0;
        $select_taxi_company = mysqli_query($con,"SELECT * FROM `taxi_comp` WHERE `active` = '1' ORDER BY `Id` ASC"); 
        while($row_taxi_company = mysqli_fetch_array($select_taxi_company)) { $i++;
      ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row_taxi_company['company_name']; ?></td>
        <td><img src="img/<?php echo $row_taxi_company['logo'];?>" width="35" height="35"/></td>
        <td><?php echo $row_taxi_company['day_price_km']; ?> Lei</td>
        <td><?php echo $row_taxi_company['night_price_km']; ?> Lei</td>
        <input type="hidden" id="km_<?php echo $i; ?>" value="" />
        <input type="hidden" id="price_day_<?php echo $i; ?>" value="<?php echo $row_taxi_company['day_price_km']; ?>"/>
        <input type="hidden" id="price_night_<?php echo $i; ?>" value="<?php echo $row_taxi_company['night_price_km']; ?>"/>
        <td id="rout_price_<?php echo $i; ?>"></td>
        <td><button type="button" class="btn" href="#test_modal" data-toggle="modal" onclick="set_comp(<?php echo $row_taxi_company['Id']; ?>)">Order</button></td>
      </tr>
      <?php } ?>
      <input type="hidden" id="length_km" value="<?php echo $i; ?>"/>
    </tbody>
</table>
<div id="taxi_response"></div>
<div class="modal fade" style="max-width:50%; max-height:50%; margin:auto; padding:0px; border:2px solid white; border-radius:15px; box-shadow:3px 6px 6px;" id="test_modal">
    <div class="modal-header" style="background: blue; opacity:0.6;">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="popup_text">Personal Information</h3>
    </div>
    <div class="modal-body">
    <div class="form-group has-success">
        <label style="color: white;" class="control-label" for="name">Lastname and Firstname : </label>
        <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group has-success">
        <label style="color: white;" class="control-label" for="phone">Phone number : </label>
        <input type="text" class="form-control" id="phone">
    </div>
    <div class="form-group has-success">
        <label style="color: white;" class="control-label" for="comment">Comment : </label>
        <textarea class="form-control" rows="3" id="comment"></textarea>
        <input type="hidden" id="id_comp" comp=""/>
    </div>
  </div>
  <div class="modal-footer">
    <a  class="btn btn-primary" data-dismiss="modal">Close</a>
    <a  class="btn btn-primary" onclick="send_order()">Send Order</a>
  </div>
</div>
<?php include('footer.php'); ?>
