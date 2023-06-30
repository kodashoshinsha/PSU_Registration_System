<?php
include "connection.php";

$fcID = $_GET["id_num"];
$regex = '/^\[F,C]{2}-[U,R]{2}-\d{4}$/';
$sql = "SELECT id_num FROM admin WHERE id_num='$fcID'";
$result = mysqli_query($con, $sql);

$result = mysqli_query($con, $sql);
if (!$result) {
    echo "Error executing SQL query: " . mysqli_error($con);
    exit;
}

if (empty($fcID)){
    echo "<span style='color:red; font-family:arial;'>This field is required</span>";
}
else if (mysqli_num_rows($result) > 0) {
    echo "<span style='color:red; font-family:arial;'>This ID is already registered</span>";
}
else {
    if (!preg_match($regex, $fcID)) {
        echo "<span style='color:red; font-family:arial;'>Please enter a valid ID number</span>";
    }
}

mysqli_close($con);
?>
