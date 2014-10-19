<?php include('header.php'); ?>

<?php include('menu_admin_interface.php'); ?>
<style type="text/css">
body {
        padding-top: 0;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
</style>
<div class="container">

      <form class="form-signin" action="login_interface.php" method="post" name="login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <button class="btn btn-large btn-primary" type="submit" name="login">Sign in</button>
      </form>
        
    </div> 
    
    <?php
     //var_dump($_SESSION);
    
        if(isset($_POST['login'])) {
            
            $username = secure_injection($con,$_POST['username']);
            $password = secure_injection($con,$_POST['password']);
            
            $select_user = mysqli_query($con,"SELECT * FROM `taxi_drivers` WHERE `username` = '".$username."' AND `password` = '".$password."' ");
            $num_rows = mysqli_num_rows($select_user);
            
            if($num_rows) {
                $row_user = mysqli_fetch_assoc($select_user);
                
              if($row_user['username'] == 'admin'){
                $_SESSION['drivers'] = $row_user;
                $_SESSION['logat'] = 1;
                redirect_page('admin_interface.php');
              }else{
                mysqli_query($con,"UPDATE `taxi_drivers` SET `active` = '1' WHERE `Id` = '".$row_user['Id']."' ");
                $_SESSION['drivers'] = $row_user;
                $_SESSION['logat'] = 1;
                
                redirect_page('taxi_interface.php');
              }  
                
                
            } else {
              echo '<script>alert("This username or password doesn\'t exist in our database !")</script>';
            }
        }
    
    ?> 

<?php include('footer.php');?>