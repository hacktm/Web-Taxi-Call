<?php include('header.php');
if(!$_SESSION['logat'] == 1){header('location:  login_interface.php');}
      include('menu_admin_interface.php'); ?>

<script>
  function add_taxi_driver() {
    var ok = true;
    var id_comp = $('#company').val();
    switch(id_comp.toLowerCase()) {
      case 'hello taxi' : id_comp = 1;
      break;
      case 'fulger taxi' : id_comp = 2;
      break;
      case 'start taxi' : id_comp = 3;
      break;
      case 'city taxi' : id_comp = 4;
      break;
      default : {
        alert('The taxi company is incorrect !');
        ok = false;
      }
    }
    var name = $('#name').val();
    var phone_nr = $('#phone_nr').val();
    var indicative = $('#indicative').val();
    var drive = $('#drive').val();
    var username = $('#username').val();
    var password = $('#inputPassword').val();
    var password_conf = $('#input2Password').val();
    if(password == password_conf) {
      if(ok) {
          $.post("ajax.php",{
          add_taxi_driver : 1,
          id_company : id_comp,
          name : name,
          phone_number : phone_nr,
          indicative : indicative,
          drive : drive,
          active : 0,
          total_km : 0,
          total_money : 0,
          password : password,
          username : username
        },function(data,status){
          alert('Congrats ! User added succesfully !');
          window.location.replace('admin_interface.php');
        });
      }

    } else {
      alert('Password incorrect !');
    }

  }
</script>
<style>
  ::-webkit-input-placeholder {
      color:    blueviolet;
  }
  :-moz-placeholder { 
     color:    blueviolet;
     opacity:  1;
  }
  ::-moz-placeholder { 
     color:    blueviolet;
     opacity:  1;
  }
  :-ms-input-placeholder { 
     color:    blueviolet;
  }
</style>
<div id="add_taxi_interface">
  <form class="form-horizontal">
        <div id="profile_img">
          <img src="http://anytimefitness.blob.core.windows.net/shared-images/spot/no-profile.png" style="width:8%;height:8%; display:inline-block; margin-left:6%; margin-bottom:6%; border-radius:10%; display:inline-block;"/>
          <div style="display: inline-block; margin-left:40px;">
            <input class='info_box' type="text" id="name" placeholder="Driver's name"/>
            <input class='info_box' type="text" id="phone_nr" placeholder="Driver's phone number"/>
            <input class='info_box' type="text" id="indicative" placeholder="Driver's indicative"/>
          </div>
          <div style="display: inline-block; margin-left:15px;">
            <input class='info_box' type="text" id="company" placeholder="Company"/>
            <input class='info_box' type="text" id="drive" placeholder="Driver's work car"/>
            <input class='info_box' type="text" id="username" placeholder="Username"/>
          </div>
        </div>
        <br />
        <div style="margin-left:10%;">
          <div class="form-group">
              <label for="inputEmail" class="control-label col-xs-2" style="width:6%; display:block; margin-left:20px;">Email</label>
              <div class="col-xs-10" style="margin-left: 18px;">
                  <input type="email" class="form-control" id="inputEmail" placeholder="Email" style="width:60%;" />
              </div>
          </div>
          <div class="form-group">
              <label for="inputPassword" class="control-label col-xs-2" style="width:6%; display:block; margin-left:20px;">Password</label>
              <div class="col-xs-10" style="margin-left: 18px;">
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password" style="width:60%;" />
              </div>
          </div>
          <div class="form-group">
              <label for="input2Password" class="control-label col-xs-2" style="width:6%; display:block; margin-left:20px;">Confirm Password</label>
              <div class="col-xs-10" style="margin-left: 18px;">
                  <input type="password" class="form-control" id="input2Password" placeholder="Password" style="width:60%;" />
              </div>
               <img src="http://i58.tinypic.com/30cujad.png" height="60" width="60" style="float:right; margin-right: 2%; margin-top: -5.5%; border-radius: 10%;" title="Add Taxi Driver" onclick="add_taxi_driver()"/>
          </div>
        </div>
       
    </form>
</div>

<?php include('footer.php'); ?>