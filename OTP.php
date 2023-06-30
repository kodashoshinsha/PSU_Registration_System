<?php
//Database connection
session_start();
include ('connection.php');

if(isset($_POST['send_OTP']) && (!empty($_POST['OTP']))) {
  $email = $_SESSION ["Gmail"];
  $OTP = $_POST['OTP'];
  $sql = "SELECT * FROM student WHERE token='$OTP' AND email='$email'";
  $result = mysqli_query($con,$sql);
  if (mysqli_num_rows($result) == 1) {
    header("Location: password_reset.php");
    $_SESSION["OTP"] = $OTP;
        }
    else {
      echo "<html>
      <head>
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
      <link rel='icon' type='image/x-icon' href='psu_logo-removebg-preview.ico' />
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>
      <title>Pangasinan State University</title>
      </head>
     <body>
 
     <script> 
     Swal.fire({
         title:'Incorrect OTP code!',
         icon:'error',
         buttons:{
             confirm: {
                 text: 'OK',
                 value: true,
                 visible: true
                 // className: 'btn-primary',
                     }
                 }
        })
        .then((value) => {
        if (value) {
         window.location.href = 'OTP.php';
             }
         })</script>
     </body>
     </html>";
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
    <link rel="icon" type="image/x-icon" href="images/psu_logo-removebg-preview.ico" />
    <link rel="stylesheet" href="css/style1.css">
    <title>Pangasinan State University</title>
</head>
<body>
<form method="POST">  
<div class="reset">
  <div class="mb-3">
    <label for="OTPinput" id="code-label" class="form-label">Enter the OTP sent to your email</label>
    <input type="number" name="OTP" id="otp" class="form-control" required>
    <span id="id-status"></span>
    <span></span>
  </div>
  <button type="submit" name="send_OTP" id="otp-btn" class="btn btn-primary">Send</button>
  </div>
</form>
</body>
</html>

<?php include 'footer.php';