<?php include('connect_db.php');

function redirect_page($link) {
    echo '<script>window.location.replace("'.$link.'");</script>';
}

function secure_injection($con,$str) {
    $str = mysqli_real_escape_string($con,$str);
    return $str;
}
function alert1($message){
    $return = "<script>alert('".$message."');</script>";
    return $return;
}
function xss_protection($str) {
    $str = htmlspecialchars($str);
    return $str;
}
function select_from_street_name($con) {
    $select_street_name = mysqli_query($con,"SELECT * FROM `street_name` WHERE `active`='1'");
    while($row_street_name = mysqli_fetch_array($select_street_name)){
        ?>
        <option value="<?php echo $row_street_name['name']; ?>"><?php echo $row_street_name['name']; ?></option>
        <?php
    }
}
function select_street_number() {
    for($i=1;$i<=100;$i++) {
        ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php
    }
}
function getClientIP() {

    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}

?>