<?php
session_start();
include ('connection.php');
$verify = $_SESSION["Email_address_student"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="images/psu_logo-removebg-preview.ico" />
    <title>Pangasinan State Univeristy</title>
</head>
<body>
<div class="alert alert-primary" role="alert">
  <h4 class="alert-heading">Verify your email account</h4>
  <p>We have sent the activation link to <?php echo $verify ?>, activate this link in order to login.
  </div>
</body>
</html>

<?php
include "footer.php";
?>