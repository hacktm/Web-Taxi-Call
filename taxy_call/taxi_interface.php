<?php include('header.php');
   if(!$_SESSION['logat'] == 1){header('location:  login_interface.php');}
   include('menu_taxi_interface.php');
   //var_dump($_SESSION);
   ?>
   
   <div class="jumbotron">
        <h2 style="text-align: center;">Welcome to the taxi interface ! Driver : <?php echo $_SESSION['drivers']['name'];?></h2>
        <div id="response_server"></div>
        <div id="order_maps"></div>
    </div>
    <script>
        $(document).ready(function(){
            setInterval(function(){
                $.post("ajax.php",{
                    check_command_taxi : 1,
                    id_company : <?php echo $_SESSION['drivers']['id_company']; ?>
                },function(data,status){
                    $('#response_server').html(data);
                });
            },5000);
        });
    </script>
<?php include('footer.php'); ?>