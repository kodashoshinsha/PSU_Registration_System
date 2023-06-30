<?php

include "connection.php";

$pass = $_GET["pass"];
if (empty($pass)) {
    echo "<span style='color:red; font-family:arial;'>This field is required</span>";
    }
else {    
    if (strlen($pass) < 8) {
    echo "<span style='color:red; font-family:arial;'>Password must be 8-16 characters long</span>";
}
}
mysqli_close($con);
?>
