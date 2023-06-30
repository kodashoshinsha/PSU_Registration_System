<?php
//Connection to the database
  include ('connection.php');

if (isset ($_GET['email']) && isset($_GET['code'])) {
    $query = "SELECT * FROM `admin` WHERE `email` = '$_GET[email]' AND `code` = '$_GET[code]'";
    $result = mysqli_query($con,$query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_assoc($result);
            if ($fetch['status'] == "Not verified") {
                $update = "UPDATE `admin` SET `status` = 'Verified' WHERE `email` = '$fetch[email]' ";
                if (mysqli_query($con,$update)){
    
                }
                else {
                    echo "Email verification failed, Please try again";
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    <link rel="icon" type="image/x-icon" href="images/psu_logo-removebg-preview.ico" />
    <title>Email verified</title>
    <div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Verification successfull!</h4>
  <p>Your registration is finished. You can now <a href="login_admin.php" style="text-decoration:none"> login </a>
  </p>
</head>
<body>
</body>
</html>

<?php 
include 'footer.php'
?>