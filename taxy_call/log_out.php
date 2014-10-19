<?php include('connect_db.php');
      include('function.php');
    session_destroy();
    redirect_page('index.php');
?>