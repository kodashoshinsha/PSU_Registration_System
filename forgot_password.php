<?php
session_start();
include ('connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function resetMail ($email,$token) {
//Load Composer's autoloader
require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/SMTP.php");
require ("PHPMailer/Exception.php");

//Create an instance; passing `true` enables exceptions
$reset = new PHPMailer(true);
try {
    //Server settings
    $reset->SMTPDebug = 2;                      
    $reset->isSMTP();                                            //Send using SMTP
    $reset->Host       = 'smtp.gmail.com';                     //This is  SMTP server to send through
    $reset->SMTPAuth   = true;                              
    $reset->Username   = 'kodashoshinsha@gmail.com';           //SMTP username
    $reset->Password   = 'bfmymlyoahrkurjn';                   //SMTP password
    $reset->SMTPSecure = 'tls';                                //Enable implicit TLS encryption
    $reset->Port       = 587;                                  //TCP port is set to 587 

    //Recipients
    $reset->setFrom('christeiesu@gmail.com','PSU URDANETA MIS');
    $reset->addAddress($email);                                  //Adds the email of the recipient

    //Mail Content
    $reset->isHTML(true);                                  //Set email format to HTML
    $reset->Subject = 'Password reset OTP';               //Gmail subject
    $reset->Body    = "Your password reset OTP is: $token. Please do not share your OTP to others";   //Gmail body message
    $reset->send();
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error:";
    return false;
}
}    
if (isset($_POST['send'])) {
    $email = stripslashes($_POST['email']);
    $email = mysqli_escape_string($con,$_POST['email']);
    $token = rand(100000, 999999);
    $check = "SELECT COUNT(*) as allcount FROM `student` WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con,$check);
    $count = mysqli_fetch_array($result);
    $allcount = $count ['allcount'];
    //If user input does not exist yet, insert into the database
    if ($allcount == 1) {
        $query = "UPDATE `student` SET token = $token WHERE email = '$email' ";
        if (mysqli_query($con, $query) && resetMail($_POST['email'],$token))
        {
            echo "Passowrd OTP sent";
            $_SESSION["Gmail"] = $email;
            header('location:OTP.php');
            exit ();
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
               title:'Email not found!',
               text:'Enter your registered email address',
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
               window.location.href = 'forgot_password.php';
                   }
               })</script>
           </body>
           </html>";
        }
    }
    mysqli_close ($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="images/psu_logo-removebg-preview.ico " />
    <link rel="stylesheet" href="css/style1.css">
    <title>Pangasinan State University</title>
</head>
<body>
<form method="POST">
<div class="reset">
  <div class="mb-3">
    <label for="exampleInputEmail1" id="email-label" class="form-label">Enter your email address to receive your reset OTP</label>
    <input type="text" name="email" id="emailrecovery" class="form-control" placeholder="Email address" required>
  </div>
  <button type="submit" name="send" id="email-btn" class="btn btn-primary">Send</button>
  </div>
</form>
</body>
</html>

<?php
include "footer.php";
?>
