<?php
    session_start();
    include ('connection.php');

    if(isset($_POST['save'])) {
        $pass1 = stripslashes($_POST['pass1']);
        $pass1 = mysqli_escape_string($con,$pass1);
        $pass2 = stripslashes($_POST['pass2']);
        $pass2 = mysqli_escape_string($con,$pass2);
        $gmail = $_SESSION["Gmail"];
        $OTP = $_SESSION["OTP"];
        if ($pass1 != $pass2) {
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
            title:'Password does not match!',
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
            window.location.href = 'password_reset.php';
                }
            })</script>
          </body>
          </html>";
            
        }
        else {
        $hash = password_hash($pass1,PASSWORD_DEFAULT);
        mysqli_query($con,"UPDATE student SET password='$hash' WHERE email='$gmail' AND token='$OTP'");
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
      title:'Password reset successfully!',
      icon:'success',
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
      window.location.href = 'login_student.php';
          }
      })</script>
    </body>
    </html>";
        }
        mysqli_close($con);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/psu_logo-removebg-preview.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <title>Pangasinan State Univeristy</title>
</head>
<body>
<form  method="POST">
<div class="reset">
  <div class="mb-3">
    <label for="exampleInputEmail1" id="pswd-label1" class="form-label">Create new password</label>
    <input type="password" name="pass1" class="form-control" id="pswd" required aria-describedby="emailHelp" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" id="pswd-label" class="form-label">Confirm password</label>
    <input type="password" name="pass2" class="form-control" id="pswd" required>
  </div>
  <button type="submit" name="save" id="reset-btn" class="btn btn-primary">Save new password</button>
</div>
</form>    
</body>
</html>
