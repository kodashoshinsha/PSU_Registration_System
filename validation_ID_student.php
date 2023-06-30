<?php

include "connection.php";

$stID = $_GET["id_num"];
$regex = "~^\d{2}-[U,R]{2}-\d{4}$~";

$sql = "SELECT id_num FROM student WHERE id_num='$stID'";
$result = mysqli_query($con, $sql);
if (empty($stID)){
    echo "<span style='color:red; font-family:arial;'>This field is required</span>";
}
else if (mysqli_num_rows($result) > 0) {
    echo "<span style='color:red; font-family:arial;'>This ID is already registered</span>";
}
else {
    if (!preg_match($regex, $stID)) {
        echo "<span style='color:red; font-family:arial;'>Please enter a valid ID number</span>";
    }
}

mysqli_close($con);
?>
