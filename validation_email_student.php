<?php
include "connection.php";

$email = $_GET["email"];
$regex = '/^[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z]+$/';
$sql = "SELECT email FROM student WHERE email = '$email'";
$result = mysqli_query($con, $sql);
if(empty($email)) {
    echo "<span style='color:red; font-family:Arial;'>This field is required</span>"; 
    }
else if (mysqli_num_rows($result) > 0) {
    // Email is already taken
    echo "<span style='color:red; font-family:Arial;'>This email is already taken</span>";
}
else {
    if (!preg_match($regex, $email)) {
        echo "<span style='color:red; font-family:Arial;'>Please enter a valid email address</span>";
         }
}
// Close the database connection
mysqli_close ($con);
?>
