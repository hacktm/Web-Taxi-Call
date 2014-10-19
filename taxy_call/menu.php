<script>
  function appear_end() {
    $('#end_tr').show();
    //$('#sep_line').show();
  }
</script>
<nav class="navbar navbar-default" role="navigation" style="border-bottom:0;" id="navbar_index">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">TaxiCall</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav"> 
    <table style="margin-left: 5em;">
      <tr>
        <td>
            <div id="start_location">
            <label>Start: </label>
              <select id="start" onchange="appear_end()">
                 <option value="">Select....</option>
                 <?php 
                    $select_street_name = mysqli_query($con,"SELECT *FROM `street_name` WHERE `active`='1'");
                    while($row_street_name = mysqli_fetch_array($select_street_name)) { 
                 ?>
                 <option value="<?php echo $row_street_name['name']; ?>"><?php echo $row_street_name['name']; ?></option>
                <?php } ?>
                </select>
              <label>No :</label>
                <select class="btn btn-mini" id="no_start" onchange="appear_end()">
                    <?php echo select_street_number(); ?>
                </select>
            </div>
        </td>
      </tr>
      <tr id="end_tr" style="display: none;">
        <td>
          <div id="end_location">
            <label>End: </label>
            <select id="end" onchange="calcRoute();" style="margin-left: 0.44em;">
              <option value="">Select....</option>
                  <?php 
                    $select_street_name = mysqli_query($con,"SELECT *FROM `street_name` WHERE `active`='1'");
                    while($row_street_name = mysqli_fetch_array($select_street_name)) { 
                  ?>
                  <option value="<?php echo $row_street_name['name']; ?>"><?php echo $row_street_name['name']; ?></option>
                  <?php } ?>
                    </select>
                    <label>No :</label>
                    <select class="btn btn-mini" id="no_end" onchange="calcRoute()">
                    <?php echo select_street_number(); ?>
                </select>
          </div>
        </td>
      </tr>
    </table>
    </ul>    
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="login_interface.php">Login as driver/admin</a></li>
            <!--<li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li> -->
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>