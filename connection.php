<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "systemdb";

$con = mysqli_connect($host, $user, $password, $db_name);  

if (!$con) {  
   echo "Databse connection failed".mysqli_connect_error();  
}  

?>